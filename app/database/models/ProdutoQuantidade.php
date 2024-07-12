<?php

namespace app\database\models;

use PDOException;

class ProdutoQuantidade extends Base{

    protected $table = 'produto_quantidade';

    public function find($fetchAll = true){

        try{
            $query = $this->connection->query('SELECT a.*, b.nome AS nome_produto, b.descricao AS descricao_produto FROM `produto_quantidade` a, `produtos` b WHERE a.produto_id = b.id;');
            return $fetchAll ? $query->fetchAll() : $query->fetch();
        }catch(PDOException $e){
            var_dump($e->getMessage());
        }
    }
   
}