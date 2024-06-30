<?php

namespace app\models;

use PDO;
class Connection{

    public static function connect(){

        $pdo = new PDO('mysql:host=localhost;port=3306;dbname=blog1', 'root', '', [
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_CASE => PDO::CASE_NATURAL
        ]);
        return $pdo;
    }

}