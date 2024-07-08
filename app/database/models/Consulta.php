<?php

namespace app\database\models;

use PDOException;

class Consulta extends Base{

    protected $table = 'consulta';

    
    public function find($fetchAll = true){

        try{
            $query = $this->connection->query('SELECT a.*, b.nome AS nome_cliente, c.nome as nome_medico, d.nome as nome_animal FROM `consulta` a, `user` b, `medicos` c, `animals` d WHERE a.id_dono = b.id AND a.id_medico = c.id AND a.id_animal=d.id ORDER BY a.data DESC;');
            return $fetchAll ? $query->fetchAll() : $query->fetch();
        }catch(PDOException $e){
            var_dump($e->getMessage());
        }
    }
   
}