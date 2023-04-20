# \<tool /\>

A MediaWiki tag extension to embed, link, and style contents from files hosted on GitHub repositories.

→ [Installation](#installation)  
→ [Usage](#usage)  
→ [Example](#example)  
→ [Configuration](#configuration)  
→ [Credits](#credits)  

## Installation

This extension is built on top of and requires [Jeroen's GitHub extension](https://github.com/JeroenDeDauw/GitHub). Make sure that that is installed first. Then:

1. Clone this directory.
2. In the root of your wiki, navigate to `var/www/mediawiki/extensions` and copy the entire `tool` directory there.
3. Navigate back to the main `mediawiki` folder and open the `local_settings.php` file in an editor.
4. Add `require_once( "$IP/extensions/tool/tool.php" );` at the end of the file.
5. Write and quit.

You should now be able to use the extension.

## Usage

In your wiki editor, type `<tool user="USERNAME" repo="REPONAME" file="FILENAME" />`, where `USERNAME` is the GitHub user whos repository you are linking, `REPONAME` is the name of that repository, and `FILENAME` is the path to the file you want to display from that repository.

## Example

For instance, to embed the [readme.md](https://github.com/hackersanddesigners/hdsa2019doc/blob/master/readme.md) file from [hackersanddesigners' hdsa2019doc](https://github.com/hackersanddesigners/hdsa2019doc) repository, you would type in `<tool user="hackersanddesigners" repo="hdsa2019doc" file="readme.md" />`.

**[↗ see in use ↗](https://wiki.hackersanddesigners.nl/index.php?title=ToolExample)**

## Configuration

This extension was built, configured, and styled for [hackersanddesigners](https://github.com/hackersanddesigners)' wiki, so you might be interested in changing the generated HTML and CSS.

To change the generated HTML elements, open the `tool_body.php` file. All lines starting with `$ret .= ` define an HTML line or element. Edit, add or remove these lines as you see fit. To change the way the embed is styled, edit the `tool.css` file. This should be self-explanatory.

During development, MediaWiki's caching might get in the way. In your browser's address bar you can add `&action=purge` at the end of the URL you are testing to clear the cache (and changes to the `tool.css` file will only require a force reload to become visible).

## Credits

Built under [afincato](https://github.com/afincato)'s supervision as part of an ongoing project for the [Hackers and Designers Wiki](https://wiki.hackersanddesigners.nl).

---  


written with love  
→ km < bonjour@moubarak.eu >
