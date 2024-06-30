<?php

namespace app\models;

use app\models\Connection;

class Model{
    protected $connect;

    public function __construct()
    {
        $this->connect = Connection::connect();        
    }

    public function all(){
        $sql = "SELECT * FROM `posts`";
        $all = $this->connect->query($sql);
        $all->execute();

        return $all->fetchAll();
    }

}