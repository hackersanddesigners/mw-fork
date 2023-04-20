# H&D MediaWiki fork + local dev setup

we use the nix package manager to create a specific environment to run the MediaWiki software. [devenv](https://devenv.sh) is the actual UI program that we use to describe the dev setup and manage it.

we're gonna setup:

- PHP
- a web server (Caddy)
- MySQL (MariaDB)

## setup

first of all, fetch a copy of [MediaWiki](https://www.mediawiki.org/wiki/Download) and put it under a folder named `w` (as per MW instructions). We reccommend to stick with git as a versioning mechanism for this `w` directory as well (as a submodule of this directory). Follow [these instructions](https://www.mediawiki.org/wiki/Download_from_Git#Download_a_stable_branch) to handle version mediawiki with git.

then: the configuration in `devenv.nix` defines the development environment.

### env variables

copy and rename `env.sample.toml` to `.env.toml` and replace its values from your settings in `w/LocalSettings.php`. for instance:

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

### export / import

if you want to work with a copy of the online H&D MediaWiki, you need to export the following:

- SQL database
- images folder
- `LocalSettings.php`

to export a copy of an existing database, do:

```
mysqldump -h hostname -u userid -p --default-character-set=whatever dbname > backup.sql
```

> Substituting hostname, userid, whatever, and dbname as appropriate. All four may be found in your LocalSettings.php (LSP) file. hostname may be found under $wgDBserver; by default it is localhost. userid may be found under $wgDBuser, whatever may be found under $wgDBTableOptions, where it is listed after DEFAULT CHARSET=.

see this article for more details: <https://www.mediawiki.org/wiki/Manual:Backing_up_a_wiki#Mysqldump_from_the_command_line>

for the images folder and `LocalSettings.php`, make a backup from the Mediawiki instance running online.

then we need to restore all this data:

- import database
- copy images folder
- copy `LocalSettings.php`
#### import db data

open another terminal and do:

- `devenv shell`, to enter to the correct working enviroment defined in `devenv.shell`
- `mysql -u <user>@localhost -p <wikidb> < <path/to/wikidb.sql>`, to do the db import
- `php w/maintenance/update.php` to do the database migration and other things

#### copy images folder and LocalSettings

simply copy over the images folder and `LocalSettings.php` into the MediaWiki folder.


#### Semantic Mediawiki Desintallation

https://www.semantic-mediawiki.org/wiki/Help:Deinstallation

## todo

- we could manage MediaWiki itself as a git repo
  - [see this wiki](https://www.mediawiki.org/wiki/Intranet/Intranet_Installation)


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
