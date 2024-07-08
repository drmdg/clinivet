<?php

namespace app\controllers;

use app\classes\Flash;
use app\classes\Validate;
use app\database\models\Consulta as cm;

class Consulta extends Base{

    private $validate;
    private $consulta;

    public function __construct()
    {
        $this->validate = New Validate;
        $this->consulta = New cm;
    }

    public function create($request,$response,$args){
       
        $messages = Flash::getAll();

        return $this->getTwig()->render($response,$this->setView('site/consulta_create'),[
            'title' => 'Consulta create',
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
            return redirect($response,'/consultas/create');
        }

        $created = $this->consulta->create(['id_animal' => $id_animal,'id_medico' => $id_medico, 'tipo_consulta' => $tipo_consulta ,'id_dono' => $id_dono]);
        if($created){
            Flash::set('message','Cadastrado com sucesso');
            return redirect($response,'/consultas/create');
        }
        Flash::set('message','Ocorreu um erro ao cadastrar a consulta');
        return redirect($response,'/consultas/create');
        
        return $response;
    }

    public function edit($request,$response,$args){
        $id = filter_var($args['id'],FILTER_SANITIZE_NUMBER_INT);

        $consulta = $this->consulta->findBy('id',$id);

        if(!$consulta){
            Flash::set('message','Consulta inexistente', 'danger');
            return redirect($response,'/consultas');
        }

        $messages = Flash::getAll();

        return $this->getTwig()->render($response,$this->setView('site/consulta_edit'),[
            'title' => 'Consulta edit',
            'consulta' => $consulta,
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
            return redirect($response,'/consultas/edit/'.$id);
        }

        $updated = $this->consulta->update(['fields' =>['id_animal' => $id_animal,'id_dono' => $id_dono,'id_medico' => $id_medico,'tipo_consulta' => $tipo_consulta],'where' => ['id' => $id]]);

        if($updated){
            Flash::set('message','Atualizado com sucesso');
            return redirect($response,'/consultas/edit/' . $id);
        }
        Flash::set('message','Erro ao atualizar','danger');
        return redirect($response,'/consultas/edit/' . $id);

    }
    public function destroy($request,$response,$args){
        $id = filter_var($args['id'],FILTER_SANITIZE_NUMBER_INT);
        
        $consulta = $this->consulta->findBy('id',$id);

        if(!$consulta){
            Flash::set('message','Consulta inexistente', 'danger');
            return redirect($response,'/');
        }

        $deleted = $this->consulta->delete('id',$id);
        
        if($deleted){
            Flash::set('message','Deletado com sucesso');
            return redirect($response,'/consultas');
        }
        Flash::set('message','Erro ao deletar','danger');
        return redirect($response,'/consultas' );

    }

    public function list($request,$response,$args){
        $consultas= $this->consulta->find();
        
        $message = Flash::get('message');

        return $this->getTwig()->render($response,$this->setView('site/consultas'),[
            'title' => 'Clientes',
            'consultas' => $consultas,
            'message' => $message
        ]);

    }
}