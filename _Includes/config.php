<?php
/*Add at the begining of the file
Database=hhibdb;Data Source=us-cdbr-azure-southcentral-f.cloudapp.net;User Id=bfab3aae3dc2f6;Password=da2733e9

*/
 
$connectstr_dbhost = 'us-cdbr-azure-southcentral-f.cloudapp.net';
$connectstr_dbname = 'hhibdb';
$connectstr_dbusername = 'bfab3aae3dc2f6';
$connectstr_dbpassword = 'da2733e9';
 
foreach ($_SERVER as $key => $value) {
 if (strpos($key, "MYSQLCONNSTR_localdb") !== 0) {
 continue;
 }
  
 $connectstr_dbhost = preg_replace("/^.*Data Source=(.+?);.*$/", "\\1", $value);
 $connectstr_dbname = preg_replace("/^.*Database=(.+?);.*$/", "\\1", $value);
 $connectstr_dbusername = preg_replace("/^.*User Id=(.+?);.*$/", "\\1", $value);
 $connectstr_dbpassword = preg_replace("/^.*Password=(.+?)$/", "\\1", $value);
}
 
// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', $connectstr_dbname);
 
/** MySQL database username */
define('DB_USER', $connectstr_dbusername);
 
/** MySQL database password */
define('DB_PASS', $connectstr_dbpassword);
 
/** MySQL hostname : this contains the port number in this format host:port . Port is not 3306 when using this feature*/
define('DB_SERVER', $connectstr_dbhost);








// Database Constants
//defined('DB_SERVER') ? null : define("DB_SERVER", "127.0.0.1:55976");
//defined('DB_USER')   ? null : define("DB_USER", "hhib");
//defined('DB_PASS')   ? null : define("DB_PASS", "koea");
//defined('DB_NAME')   ? null : define("DB_NAME", "hhib");
?>