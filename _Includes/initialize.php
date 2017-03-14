<?php
// Define the core paths
// Define them as absolute paths to make sure that require_once works as expected

// DIRECTORY_SEPARATOR is a PHP pre-defined constant
// (\ for Windows, / for Unix)
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

//defined('SITE_ROOT') ? null : define('SITE_ROOT', 'C:'.DS.'xampp'.DS.'htdocs'.DS.'HHIB');
defined('SITE_ROOT') ? null : define('SITE_ROOT', 'http://hhib.azurewebsites.net');

defined('LIB_PATH') ? null : define('LIB_PATH', SITE_ROOT.DS.'_Includes');

defined('FILES_DB') ? null : define('FILES_DB', SITE_ROOT.DS.'HHIBFILEDB');

defined('DESIGN_SETTINGS') ? null : define('DESIGN_SETTINGS', LIB_PATH.DS.'_DesignerSettings');

// load config file first
//require_once(LIB_PATH.DS.'config.php');

// load basic functions next so that everything after can use them
require_once(LIB_PATH.DS.'functions.php');

// load core objects
require_once(LIB_PATH.DS.'classes.php');
require_once(LIB_PATH.DS.'pagination.php');

//TO DO: Evry class to a diffrent file
?>