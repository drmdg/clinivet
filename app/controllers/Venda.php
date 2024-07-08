<?php

namespace app\controllers;

use app\classes\Flash;
use app\classes\Validate;
use app\database\models\Vendas;

class Venda extends Base{

    private $validate;
    private $venda;

    public function __construct()
    {
        $this->validate = New Validate;
        $this->venda = New Vendas;
    }

    public function create($request,$response,$args){
       
        $messages = Flash::getAll();

        return $this->getTwig()->render($response,$this->setView('site/venda_create'),[
            'title' => 'Venda create',
            'messages' => $messages
        ]);
    }
    public function store($request,$response,$args){
        $id_animal = filter_input(INPUT_POST,'id_animal',FILTER_SANITIZE_NUMBER_INT);
        $id_dono = filter_input(INPUT_POST,'id_dono',FILTER_SANITIZE_NUMBER_INT);
        $id_medico = filter_input(INPUT_POST,'id_medico',FILTER_SANITIZE_NUMBER_INT);
        $tipo_consulta = filter_input(INPUT_POST,'tipo_consulta',FILTER_SANITIZE_STRING);


        $this->validate->required(['id_animal','id_dono','id_medico','tipo_consulta']);
        $errors = $this->validate->getErrors();

        if($errors){
            Flash::flashes($errors);
            return redirect($response,'/vendas/create');
        }

        $created = $this->venda->create(['id_animal' => $id_animal,'id_medico' => $id_medico, 'tipo_consulta' => $tipo_consulta ,'id_dono' => $id_dono]);
        if($created){
            Flash::set('message','Cadastrado com sucesso');
            return redirect($response,'/vendas/create');
        }
        Flash::set('message','Ocorreu um erro ao cadastrar a venda');
        return redirect($response,'/vendas/create');
        
        return $response;
    }

    public function edit($request,$response,$args){
        $id = filter_var($args['id'],FILTER_SANITIZE_NUMBER_INT);

        $venda = $this->venda->findBy('id',$id);

        if(!$venda){
            Flash::set('message','Venda inexistente', 'danger');
            return redirect($response,'/vendas');
        }

        $messages = Flash::getAll();

        return $this->getTwig()->render($response,$this->setView('site/venda_edit'),[
            'title' => 'Consulta edit',
            'venda' => $venda,
            'messages' => $messages
        ]);
    }

    public function update($request,$response,$args){
        $id_animal = filter_input(INPUT_POST,'id_animal',FILTER_SANITIZE_NUMBER_INT);
        $id_dono = filter_input(INPUT_POST,'id_dono',FILTER_SANITIZE_NUMBER_INT);
        $id_medico = filter_input(INPUT_POST,'id_medico',FILTER_SANITIZE_NUMBER_INT);
        $tipo_consulta = filter_input(INPUT_POST,'tipo_consulta',FILTER_SANITIZE_STRING);
        $id = filter_var($args['id'],FILTER_SANITIZE_NUMBER_INT);


        $this->validate->required(['id_animal','id_dono','id_medico','tipo_consulta']);
        $errors = $this->validate->getErrors();

        if($errors){
            Flash::flashes($errors);
            return redirect($response,'/vendas/edit/'.$id);
        }

        $updated = $this->venda->update(['fields' =>['id_animal' => $id_animal,'id_dono' => $id_dono,'id_medico' => $id_medico,'tipo_consulta' => $tipo_consulta],'where' => ['id' => $id]]);

        if($updated){
            Flash::set('message','Atualizado com sucesso');
            return redirect($response,'/vendas/edit/' . $id);
        }
        Flash::set('message','Erro ao atualizar','danger');
        return redirect($response,'/vendas/edit/' . $id);

    }
    public function destroy($request,$response,$args){
        $id = filter_var($args['id'],FILTER_SANITIZE_NUMBER_INT);
        
        $venda = $this->venda->findBy('id',$id);

        if(!$venda){
            Flash::set('message','Consulta inexistente', 'danger');
            return redirect($response,'/');
        }

        $deleted = $this->venda->deleteVenda('id',$id);
        
        if($deleted){
            Flash::set('message','Deletado com sucesso');
            return redirect($response,'/vendas');
        }
        Flash::set('message','Erro ao deletar','danger');
        return redirect($response,'/vendas' );

    }

    public function list($request,$response,$args){
        $vendas= $this->venda->find();
        $vendasFiltradas = [];
        foreach ($vendas as $venda) {
            if ($venda->status_venda == 1) {
                $vendasFiltradas[] = $venda;
            }
        }

        $message = Flash::get('message');

        return $this->getTwig()->render($response,$this->setView('site/vendas'),[
            'title' => 'Clientes',
            'vendas' => $vendasFiltradas,
            'message' => $message
        ]);

    }
}