<?php

namespace app\database\models;

use PDOException;

class Vendas extends Base{

    protected $table = 'vendas';

    public function find($fetchAll = true){

        try{
            $query = $this->connection->query('SELECT a.*, b.nome AS nome_cliente FROM `vendas` a, `user` b WHERE a.id_cliente = b.id ORDER BY a.data_venda DESC');
            return $fetchAll ? $query->fetchAll() : $query->fetch();
        }catch(PDOException $e){
            var_dump($e->getMessage());
        }
    }

    public function findVendaIncompletaByIdUser($id){
        try{
            $prepared = $this->connection->prepare("select * from {$this->table} where id_cliente = :{$id} and status_venda = 0");
            $prepared->bindValue(":{$id}",$id);
            $prepared->execute();
            return $prepared->fetch();
        }catch(PDOException $e){
            var_dump($e->getMessage());
        }
        
    }
   
}