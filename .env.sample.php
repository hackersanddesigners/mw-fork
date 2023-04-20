<?php

# Error reporting, only in development environment

error_reporting( -1 );
ini_set( 'display_errors', 1 );

if ( !defined( 'MEDIAWIKI' ) ) {
	exit;
}

$wgShowExceptionDetails = true;

# Secret strings to include in LocalSwettings.php. First,
# copy this file to a directory outside your webroot and then
# require_once this file in your LocalSettings.php

$wgDBtype = "";
$wgDBserver = "";
$wgDBname = "";
$wgDBuser = "";
$wgDBpassword = "";
$wgSecretKey = "";

## The protocol and server name to use in fully-qualified URLs
$wgServer = "http://localhost:8000";

?>
