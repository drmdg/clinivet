<?php

namespace app\database\models;

use PDOException;

class Animals extends Base{

    protected $table = 'animals';

    public function find($fetchAll = true){

        try{
            $query = $this->connection->query('SELECT a.*, b.nome AS nome_dono FROM `animals` a, `user` b WHERE a.id_dono = b.id');
            return $fetchAll ? $query->fetchAll() : $query->fetch();
        }catch(PDOException $e){
            var_dump($e->getMessage());
        }
    }
   
}