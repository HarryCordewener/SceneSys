<?php
# This file was automatically generated by the MediaWiki 1.24alpha
# installer. If you make manual changes, please keep track in case you
# need to recreate them later.
#
# See includes/DefaultSettings.php for all configurable settings
# and their default values, but don't forget to make changes in _this_
# file, not there.
#
# Further documentation for configuration settings may be found at:
# https://www.mediawiki.org/wiki/Manual:Configuration_settings

# Protect against web entry
if ( !defined( 'MEDIAWIKI' ) ) {
	exit;
}

## Uncomment this to disable output compression
# $wgDisableOutputCompression = true;

$wgSitename = "Scene Wiki";
$wgMetaNamespace = "Scene_Wiki";

## The URL base path to the directory containing the wiki;
## defaults for all runtime URL paths are based off of this.
## For more information on customizing the URLs
## (like /w/index.php/Page_title to /wiki/Page_title) please see:
## https://www.mediawiki.org/wiki/Manual:Short_URL
$wgScriptPath = "/SceneSys/MediaWiki";
$wgScriptExtension = ".php";

## The protocol and server name to use in fully-qualified URLs
$wgServer = "http://twilightdays.org";

## The relative URL path to the skins directory
$wgStylePath = "$wgScriptPath/skins";

## The relative URL path to the logo.  Make sure you change this from the default,
## or else you'll overwrite your logo when you upgrade!
$wgLogo = "$wgStylePath/common/images/wiki.png";

## UPO means: this is also a user preference option

$wgEnableEmail = true;
$wgEnableUserEmail = true; # UPO

$wgEmergencyContact = "admin@myhost.com";
$wgPasswordSender = "admin@myhost.com";

$wgEnotifUserTalk = false; # UPO
$wgEnotifWatchlist = false; # UPO
$wgEmailAuthentication = true;

## Database settings
$wgDBtype = "mysql";
$wgDBserver = "localhost";
$wgDBname = "scene_wiki";
$wgDBuser = "MyUser";
$wgDBpassword = "MyPassword";

# MySQL specific settings
$wgDBprefix = "wiki_";

# MySQL table options to use during installation or update
$wgDBTableOptions = "ENGINE=InnoDB, DEFAULT CHARSET=binary";

# Experimental charset support for MySQL 5.0.
$wgDBmysql5 = false;

## Shared memory settings
$wgMainCacheType = CACHE_NONE;
$wgMemCachedServers = array();

## To enable image uploads, make sure the 'images' directory
## is writable, then set this to true:
$wgEnableUploads = true;
#$wgUseImageMagick = true;
#$wgImageMagickConvertCommand = "/usr/bin/convert";

# InstantCommons allows wiki to use images from http://commons.wikimedia.org
$wgUseInstantCommons = false;

## If you use ImageMagick (or any other shell command) on a
## Linux server, this will need to be set to the name of an
## available UTF-8 locale
$wgShellLocale = "en_US.utf8";

## If you want to use image uploads under safe mode,
## create the directories images/archive, images/thumb and
## images/temp, and make them all writable. Then uncomment
## this, if it's not already uncommented:
#$wgHashedUploadDirectory = false;

## Set $wgCacheDirectory to a writable directory on the web server
## to make your wiki go slightly faster. The directory should not
## be publically accessible from the web.
#$wgCacheDirectory = "$IP/cache";

# Site language code, should be one of the list in ./languages/Names.php
$wgLanguageCode = "en";

$wgSecretKey = "9d72b0dd444b1348579a98231cd5c86f47410629b50f48283cf501c3dfef0639";

# Site upgrade key. Must be set to a string (default provided) to turn on the
# web installer while LocalSettings.php is in place
$wgUpgradeKey = "6f3ed7ac86b95469";

## Default skin: you can change the default skin. Use the internal symbolic
## names, ie 'vector', 'monobook':
$wgDefaultSkin = "vector";

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
$wgGroupPermissions['*']['edit'] = false;


# End of automatically generated settings.
# Add more configuration options below.

# Syntax Includes
require_once( "$IP/extensions/ParserFunctions/ParserFunctions.php" );
# require_once( "$IP/extensions/Validator/Validator.php" ); // Composer should do this for us
# require_once("$IP/extensions/RegexFunctions/RegexFunctions.php"); // Not installed

# Semantic Mediawiki and its extensions.
# include_once( "$IP/extensions/SemanticMediaWiki/SemanticMediaWiki.php" ); // Composer should do this for us.
enableSemantics('yourhost.ext/wiki');
# include_once("$IP/extensions/SemanticForms/SemanticForms.php");
# require_once("$IP/extensions/SemanticResultFormats/SemanticResultFormats.php"); // Not installed
# include_once("$IP/extensions/SemanticCompoundQueries/SemanticCompoundQueries.php"); // Not installed
# require_once( "$IP/extensions/MagicNoCache/MagicNoCache.php" );

# Speeding up Semantic Mediawiki
 $smwgQEqualitySupport = SMW_EQ_FULL;

# External Data
# This is in order to grab directly from SceneSys using SQL.
# Use the same Read Only selector user to do this!
include_once("$IP/extensions/ExternalData/ExternalData.php");
$edgAllowExternalDataFrom = 'http://myhost.ext';
$edgDBServer['scenesys'] = "localhost";
$edgDBServerType['scenesys'] = "mysql";
$edgDBName['scenesys'] = "scene";
$edgDBUser['scenesys'] = "selector";
$edgDBPass['scenesys'] = "db_select";

# Usability and Looks
# require_once("$IP/extensions/CSS/CSS.php");  // Not installed
# require_once( "$IP/extensions/WikiEditor/WikiEditor.php" ); // Not installed.
# require_once("$IP/extensions/HeaderTabs/HeaderTabs.php"); // Not installed

# Admin Assistance
# require_once( "$IP/extensions/ReplaceText/ReplaceText.php" ); // Not installed
# require_once("$IP/extensions/Renameuser/Renameuser.php"); // Not installed

# Anti Spam
# It is highly suggested to use ConfirmAccount.
require_once("$IP/extensions/ConfirmAccount/ConfirmAccount.php");

$wgConfirmAccountRequestFormItems = array(
        # Let users make names other than their "real name"
        'UserName'        => array( 'enabled' => true ),
        # Real name of user
        'RealName'        => array( 'enabled' => true ),
        # Terms of Service checkbox
        'TermsOfService'  => array( 'enabled' => true ),
);


# require_once("$IP/extensions/bannedips.php");
 $wgEnableDnsBlacklist = true;
 $wgDnsBlacklistUrls = array( 'xbl.spamhaus.org', 'opm.tornevall.org' );
 $wgEmailConfirmToEdit = true;


