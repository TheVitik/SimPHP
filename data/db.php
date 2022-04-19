<?php
// MYSQL
$db = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
if($db->connect_error){
    echo "MySQL Connect Error";
    die();
}