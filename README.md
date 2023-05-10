# H&D's Mediawiki Instance

is now tracked with git!

## Context

What has happened:
- We have forked [`mediaiwki/core`](https://gerrit.wikimedia.org/r/mediawiki/core) to our own github and checked out branch `REL1_39` based on [these instructions](https://www.mediawiki.org/wiki/Download_from_Git#Download_a_stable_branch))
- We have added some new environment management files for a workflow with `devenv` (see below)
- We have removed the following files from .gitignore and are officially tracking them in our branch:
  - LocalSettings.php
  - composer.local.json
- This is so that we can keep track of our configuration and better collaborate on it
- We have moved mediawiki environment variables and database secretes out of LocalSettings.php and into .env.php
- If possible, extensions and skins are tracked with Composer.
- Else, please `git submodule add` them

## Development

Clone this directory onto your local device.
```
git clone https://github.com/hackersanddesigners/mw-fork
```
Then, you have to set up the server and database of the project.

### `devenv`

We use `devenv` to get the correct php version, run a Caddy web server and a MariaDB database server for the mediawiki (and to avoid php versioning headaches). First, [install `devenv`](https://devenv.sh/). The main configuration file is in `devenv.nix` and defines the development workflow.

We have to define our environment variables: Copy and rename `env.sample.toml` to `.env.toml` and replace its values with the information about your mediawiki server and database.

- db:
  - `name`: `$wgDBname`
  - `schema`: path to a local copy of the MW db to setup its DB schema
  - `user`: `$wgDBuser`
    - the username should be `<name>@localhost`, else the user won't be able to connect to the db; this becasue `$wgDBserver` is set to `localhost`
  - `pw`: `$wgDBpassword`

- web:
  - `localhost`: `$wgServer`


then run:

```
devenv up
```
to start the local server (Caddy), PHP and MySQL processes.

From now on, it is important to run `devenv shell` in any terminal where you plan on running php or composer commands to activate this development environement. Otherwise system defaults are used, which we don't want.

### Mediawiki

We have to define our environment variables for mediawiki in `.env.php` which is a separate file from `.env.toml` but contains some of the main information and can be read by php. This file is imported into LocalSettings.php: Copy and rename `env.sample.php` to `.env.php` and replace its values from your database and server settings.

#### Database Import

To work with a copy of the online H&D MediaWiki, you need to import the following:

- SQL database
- images folder

***Please note that we do not copy the LocalSettings.php file from one computer to another anymore. It is tracked with git from now on.***

##### Database

On the server export a copy of the existing database:

```
mysqldump -h hostname -u userid -p dbname > backup.sql
```
> Substituting hostname, userid, whatever, and dbname as appropriate. All four may be found in your LocalSettings.php (LSP) file. hostname may be found under $wgDBserver; by default it is localhost. userid may be found under $wgDBuser, whatever may be found under $wgDBTableOptions, where it is listed after DEFAULT CHARSET=. [See this article for more details](https://www.mediawiki.org/wiki/Manual:Backing_up_a_wiki#Mysqldump_from_the_command_line)

And download it to this directory using your favorite tool (`rsync` or `scp`). Don't worry, all *.sql files are ignored from git.

Then, in a terminal on your local machine,
- `devenv shell`, to enter to the correct working enviroment defined in `devenv.shell`
- `mysql -u <user>@localhost -p <wikidb> < <path/to/wikidb.sql>`, to do the db import
- `php w/maintenance/update.php` to do the database migration and other things


##### Images

For the images folder, copy the current `images` folder from the Mediawiki instance running online to the `images` folder in this directory.


Now that that we have the correct version of php, the web and database servers are running, and the database and images are important, we can move forward to installing our extensions.

### Extensions & Skins

The git version of Mediawiki manages all the default extensions & skins as git submodules. So currently, they are not installed. To install them:

```
devenv shell
git submodule update --init --recursive
```

This will install all git submodules listed in the `.gitmodules` file.
The end of this file shows a few extensions that we have added ourselves. These are not in the original mediawiki/core repository and belong to our fork.

Unfortunately, not all extensions and skins can be installed in this way, so, although this is the prefered installation mechanism, when it doesn't work we will use Composer.
For this, please make sure Composer is installed and configured globally and then run:
```
composer install
```

This is will install all Vendors, Extentions and Skins managed by composer. Make note of the `composer.local.json` file that is being tracked by git. This is where we include our extensions that we could manage to install as git submodules. Also make note that all extensions listed in the `composer.local.json` are added to `.gitignore` to keep them out of our tracking.

It is definitely also possible that some extensions can not be managed as git submodules or even with Composer, in which case, please do downlaod them and unzip them into the correct directory and commit them to our work tree.

## Deployment

Clone this repository at branch 'h&d' into your web server and cd into it.
```
git clone -b 'h&d' https://github.com/hackersanddesigners/mw-fork.git
cd mw-fork
```
Then, install all vendor libraries and extensions managed by composer
```
composer install --no-dev
```
Then, install all git submodules.
```
git submodule update --init --recursive
```

Create the file `.env.php` based on the provided sample and require it in localsettings.php at the top:

```php
# evnrionment secrets
require_once "/var/www/mw-fork/.env.php";
```



## Updating

### Mediawiki

Fetch stable branch of mediawiki and merge using [git rerere](https://www.git-scm.com/book/en/v2/Git-Tools-Rerere).

### Extensions & Skins

```
git submodule fetch --init --recursive
rm composer.lock
composer update
```

## Notes
### Semantic Mediawiki Desintallation

https://www.semantic-mediawiki.org/wiki/Help:Deinstallation



---------

# MediaWiki

MediaWiki is a free and open-source wiki software package written in PHP. It
serves as the platform for Wikipedia and the other Wikimedia projects, used
by hundreds of millions of people each month. MediaWiki is localised in over
350 languages and its reliability and robust feature set have earned it a large
and vibrant community of third-party users and developers.

MediaWiki is:

* feature-rich and extensible, both on-wiki and with hundreds of extensions;
* scalable and suitable for both small and large sites;
* simple to install, working on most hardware/software combinations; and
* available in your language.

For system requirements, installation, and upgrade details, see the files
RELEASE-NOTES, INSTALL, and UPGRADE.

* Ready to get started?
  * https://www.mediawiki.org/wiki/Special:MyLanguage/Download
* Looking for the technical manual?
  * https://www.mediawiki.org/wiki/Special:MyLanguage/Manual:Contents
* Seeking help from a person?
  * https://www.mediawiki.org/wiki/Special:MyLanguage/Communication
* Looking to file a bug report or a feature request?
  * https://bugs.mediawiki.org/
* Interested in helping out?
  * https://www.mediawiki.org/wiki/Special:MyLanguage/How_to_contribute

MediaWiki is the result of global collaboration and cooperation. The CREDITS
file lists technical contributors to the project. The COPYING file explains
MediaWiki's copyright and license (GNU General Public License, version 2 or
later). Many thanks to the Wikimedia community for testing and suggestions.
