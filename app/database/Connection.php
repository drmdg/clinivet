<?php

namespace app\database;

use PDO;
use PDOException;
class Connection{

    private static $pdo = null;

    public static function connection(){

        if(static::$pdo){
            return static::$pdo;
        }

        try{
            static::$pdo = new PDO('mysql:host=localhost;port=3306;dbname=clinivet', 'root', '', [
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                PDO::ATTR_CASE => PDO::CASE_NATURAL
            ]);
            return static::$pdo;
        }catch(PDOException $e){
            var_dump($e->getMessage());
        }
    }

}