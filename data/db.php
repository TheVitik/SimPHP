<?php
/*
$db = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
if($db->connect_error){
    echo "MySQL Connect Error";
    die();
}
*/
$db = odbc_connect("Driver=MySQL ODBC 8.0 Unicode Driver;Server=".DB_HOST.";Database=".DB_NAME.";CharacterSet => UTF-8", DB_USER, DB_PASSWORD);