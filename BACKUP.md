# Backing up

To backup the H&D mediawiki, you would need to make a copy of the `./w` directory that is on the server. This will copy all the important files, especially extensions, images, skins and custom scripts. With the correct access rights, you can do this from your local machine with `scp`:

```sh
mkdir backups/todays-date
scp -R YOUR-USER@YOUR-DOMAIN:PATH/TO/YOUR/MEDIAWIKI backups/todays-date/
```

Then export an sqldump of the database and copy it to your local machine

```sh
mysqldump -h hostname -u userid -p --default-character-set=whatever dbname > backup.sql
```

> Substituting hostname, userid, whatever, and dbname as appropriate. All four may be found in your LocalSettings.php (LSP) file. hostname may be found under $wgDBserver; by default it is localhost. userid may be found under $wgDBuser, whatever may be found under $wgDBTableOptions, where it is listed after DEFAULT CHARSET=.

See this article for more details: <https://www.mediawiki.org/wiki/Manual:Backing_up_a_wiki#Mysqldump_from_the_command_line>
