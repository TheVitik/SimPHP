<?php

namespace Core;

use mysqli;
use Core\Database as DB;
class Database{
    //Database connection
    private static $db;
    private static $queryString = "";
    private static $queryResult;
    public static function init(){
        if(DB_TYPE=="MYSQL"){
            self::$db = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
        }
        else{
            die("Error DB Type, check config file.");
        }
        return True;
    }

    public static function query($sql){
        self::$queryResult = self::$db->query($sql);
        return new self();
    }
    public static function fetchArray(){
        $array = array();
        while($row = self::$queryResult->fetch_array()){
            array_push($array,$row);
        }
        return $array;
    }
    //SELECT @values
    public static function select($values): DB
    {
        self::$queryString.="SELECT $values ";
        return new self();
    }
    //FROM @table
    public static function from($table): DB
    {
        self::$queryString.="FROM $table ";
        return new self();
    }
    //INNER JOIN @table
    public static function innerJoin($table): DB
    {
        self::$queryString.="INNER JOIN $table ";
        return new self();
    }
    //ON @values
    public static function on($values): DB
    {
        self::$queryString.="ON $values ";
        return new self();
    }
    //WHERE @expression
    public static function where($expression): DB
    {
        self::$queryString.="ON $expression ";
        return new self();
    }

    public static function queryString(){
        return self::$queryString;
    }
    public static function execute(): DB
    {
        self::$queryResult = self::$db->query(self::$queryString);
        return new self();
    }
}