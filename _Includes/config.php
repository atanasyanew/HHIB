<?php
/*Add at the begining of the file*/
 
$connectstr_dbhost = 'localhost:55976';
$connectstr_dbname = 'hhib';
$connectstr_dbusername = 'hhib';
$connectstr_dbpassword = 'koea';
 
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