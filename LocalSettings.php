<?php

# This file was automatically generated by the MediaWiki 1.34.0
# installer. If you make manual changes, please keep track in case you
# need to recreate them later.
#
# See includes/DefaultSettings.php for all configurable settings
# and their default values, but don't forget to make changes in _this_
# file, not there.
#
# Further documentation for configuration settings may be found at:
# https://www.mediawiki.org/wiki/Manual:Configuration_settings


# Environment: Logging and Secrets

require_once(__DIR__.'/.env.php');

## Uncomment this to disable output compression
# $wgDisableOutputCompression = true;

$wgSitename = "Hackers & Designers";
$wgMetaNamespace = "Hackers_and_Designers";


## The URL base path to the directory containing the wiki;
## defaults for all runtime URL paths are based off of this.
## For more information on customizing the URLs
## (like /w/index.php/Page_title to /wiki/Page_title) please see:
## https://www.mediawiki.org/wiki/Manual:Short_URL
$wgScriptPath = "";

## The URL path to static resources (images, scripts, etc.)
$wgResourceBasePath = $wgScriptPath;

## The URL path to the logo.  Make sure you change this from the default,
## or else you'll overwrite your logo when you upgrade!
$wgLogo = "$wgResourceBasePath/resources/assets/HD-wiki.gif";

## UPO means: this is also a user preference option

$wgEnableEmail = true;
$wgEnableUserEmail = true; # UPO

$wgEmergencyContact = "work@andrefincato.info";
$wgPasswordSender = "info@hackersanddesigners.nl";

$wgEnotifUserTalk = false; # UPO
$wgEnotifWatchlist = false; # UPO
$wgEmailAuthentication = true;

# MySQL specific settings
$wgDBprefix = "";

# MySQL table options to use during installation or update
$wgDBTableOptions = "ENGINE=InnoDB, DEFAULT CHARSET=binary";

## Shared memory settings
$wgMainCacheType = CACHE_ACCEL;
$wgMemCachedServers = [];

## To enable image uploads, make sure the 'images' directory
## is writable, then set this to true:
$wgEnableUploads = true;
$wgUseImageMagick = true;
$wgImageMagickConvertCommand = "/usr/bin/convert";

# InstantCommons allows wiki to use images from https://commons.wikimedia.org
$wgUseInstantCommons = false;

# Periodically send a pingback to https://www.mediawiki.org/ with basic data
# about this MediaWiki instance. The Wikimedia Foundation shares this data
# with MediaWiki developers to help guide future development efforts.
$wgPingback = false;

## If you use ImageMagick (or any other shell command) on a
## Linux server, this will need to be set to the name of an
## available UTF-8 locale
$wgShellLocale = "C.UTF-8";

## Set $wgCacheDirectory to a writable directory on the web server
## to make your wiki go slightly faster. The directory should not
## be publicly accessible from the web.
#$wgCacheDirectory = "$IP/cache";

# Site language code, should be one of the list in ./languages/data/Names.php
$wgLanguageCode = "en";


# Changing this will log out all existing sessions.
$wgAuthenticationTokenVersion = "1";

# Site upgrade key. Must be set to a string (default provided) to turn on the
# web installer while LocalSettings.php is in place
$wgUpgradeKey = "23cfe60defdce75a";

## For attaching licensing metadata to pages, and displaying an
## appropriate copyright notice / icon. GNU Free Documentation
## License and Creative Commons licenses are supported so far.
$wgRightsPage = ""; # Set to the title of a wiki page that describes your license/copyright
$wgRightsUrl = "";
$wgRightsText = "";
$wgRightsIcon = "";

# Path to the GNU diff3 utility. Used for conflict resolution.
$wgDiff3 = "/usr/bin/diff3";

# The following permissions were set based on your choice in the installer
$wgGroupPermissions['*']['createaccount'] = false;
$wgGroupPermissions['*']['edit'] = false;

## Default skin: you can change the default skin. Use the internal symbolic
## names, ie 'vector', 'monobook':

$wgDefaultSkin = "vector-2022";

# Enabled skins.
# The following skins were automatically enabled:
wfLoadSkin( 'MonoBook' );
wfLoadSkin( 'Timeless' );
wfLoadSkin( 'Vector' );

# End of automatically generated settings. Add more configuration
# options below.



# ?????

$wgEnableBotPasswords = true;



# Delete users by merging them: By default nobody can use
# this function, enable for bureaucrat? optional: default is
# array( 'sysop' )

wfLoadExtension( 'UserMerge' );
$wgGroupPermissions['bureaucrat']['usermerge'] = true;
$wgUserMergeProtectedGroups = array( 'groupname' );


# Enable page forms for tempaltes

wfLoadExtension( 'PageForms' );


# Editors

wfLoadExtension( 'WikiEditor' );
wfLoadExtension( 'SyntaxHighlight_GeSHi' );
wfLoadExtension( 'VisualEditor' );
wfLoadExtension( 'CodeEditor' );


# Embed Video / doesnt work

wfLoadExtension("EmbedVideo");


# Custom Tool embed, used to import readme files from github
# and add them into a little widget in the page

wfLoadExtension( 'ExternalContent' );
$egGitHubDefaultRepo = 'karlmoubarak/ToolSample';
$egGitHubUrl = 'https://raw.githubusercontent.com';
require_once( "$IP/extensions/tool/tool.php" );


# Support HTML tags: allow only `<audio>` and `<iframe>`
# tags, with specific tag attributes

wfLoadExtension( 'HTMLTags' );
$wgHTMLTagsAttributes['audio'] = ['controls', 'src', 'type'];
$wgHTMLTagsAttributes['iframe'] = ['src', 'width', 'height', 'frameborder'];


# List pages belongingt o a category anywhere

wfLoadExtension( 'CategoryTree' );


# Language and translation

wfLoadExtension( 'Babel' );
wfLoadExtension( 'Cldr' );
wfLoadExtension( 'UniversalLanguageSelector' );
wfLoadExtension( 'Translate' );
wfLoadExtension( 'CleanChanges' );
$wgDefaultUserOptions['usenewrc'] = 1;

# Translation and translation task management permissions

$wgGroupPermissions['user']['translate'] = true;
$wgGroupPermissions['user']['translate-messagereview'] = true;
$wgGroupPermissions['user']['translate-groupreview'] = true;
$wgGroupPermissions['user']['translate-import'] = true;
$wgGroupPermissions['user']['pagetranslation'] = true;
$wgGroupPermissions['user']['translate-manage'] = true;

$wgTranslateDocumentationLanguageCode = 'qqq';

$wgTranslateLanguageFallbacks['nl'] = 'en';

$wgEnablePageTranslation = true;


# for mass editing of pages

wfLoadExtension( 'ReplaceText' );
$wgReplaceTextResultsLimit = 500;





# support citations

wfLoadExtension( 'Cite' );


# Max count for category tree
$wgCategoryTreeMaxChildren = 1000;






# end
