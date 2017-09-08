<?
/**
 * Connect to the mysql database.
 */
$conn=mysql_connect("localhost", "root", "luttikcie teamsport");
mysql_select_db('teamsport_app_n', $conn) or die(mysql_error());


/**
 * Translation settings
 */
$sourceFolder1 = "/var/www";
$sourceFolder2 = "/var/www/mobile";
$targetFolder1 = "/var/www-test";
$separator = "/";
$windows = false;

/**
 * Admin security settings
 */

global $allowAdminAccess1;
global $allowAdminAccess2;
global $allowAdminAccess3;
global $allowAdminAccess4;
global $adminpasswd;

$allowAdminAccess1 = "82.161.244.200"; // huis
$allowAdminAccess2 = "82.95.252.170"; // huis
$allowAdminAccess3 = "127.0.0.1" ; // lokaal
$allowAdminAccess4 = "192.168.178.29"; // laptop
$adminpasswd = "admindax";

/**
 * Translate security settings
 */

global $allowTranslateAccess1;
global $allowTranslateAccess2;
global $allowTranslateAccess3;
global $allowTranslateAccess4;
global $translatepasswd;

$allowTranslateAccess1 = "24.132.26.137"; // dax
$allowTranslateAccess2 = "82.95.252.170"; // huis
$allowTranslateAccess3 = "127.0.0.1" ; // lokaal
$allowTranslateAccess4 = "192.168.178.29"; // laptop
$translatepasswd = "admindax";


?>



