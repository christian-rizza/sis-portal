<?php
/**
 * @author Christian Rizza
 * www.crizza.com
 * email: christian@crizza.com
 */

//*
define('DB_NAME', 'name');
define('DB_USER', 'user');
define('DB_PASS', 'pass');
define('DB_HOST', 'host');
//*/


include_once BASE_PATH."/classes/MysqlConnector.php";
include_once BASE_PATH."/classes/Login.php";
include_once BASE_PATH."/classes/Course.php";
include_once BASE_PATH."/classes/Subject.php";
include_once BASE_PATH."/classes/Plan.php";
include_once BASE_PATH."/classes/Student.php";
include_once BASE_PATH."/classes/Exam.php";
include_once BASE_PATH."/classes/Payment.php";
include_once BASE_PATH."/classes/PaymentEntry.php";
include_once BASE_PATH."/classes/Booking.php";
include_once BASE_PATH."/classes/Notice.php";
include_once BASE_PATH."/classes/Document.php";
include_once BASE_PATH."/classes/PasswordGenerator.php";


// DEBUG
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
ini_set( "display_errors", false);
ini_set( "default_charset", "utf-8");
error_reporting (E_ALL ^ E_NOTICE);
$GLOBALS['offline'] = false;
 
?>