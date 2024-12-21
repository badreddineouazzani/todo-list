<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASS','');
define('DB_NAME','todo-list');

$conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);

if ($conn->connect_error ) {
    die("Connection failed: " . $conn->connect_error);
}else {
    //echo "Connection succeeded ". PHP_VERSION;
} 

?>