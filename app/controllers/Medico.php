<?php

namespace app\controllers;

use app\classes\Flash;
use app\classes\Validate;
use app\database\models\Medicos;

class Medico extends Base{

    private $validate;
    private $medico;

    public function __construct()
    {
        $this->validate = New Validate;
        $this->medico = New Medicos;
    }

    public function create($request,$response,$args){
       
        $messages = Flash::getAll();

        return $this->getTwig()->render($response,$this->setView('site/medico_create'),[
            'title' => 'Medico create',
            'messages' => $messages
        ]);
    }
    public function store($request,$response,$args){
        $nome = filter_input(INPUT_POST,'nome',FILTER_SANITIZE_STRING);
        $crm = filter_input(INPUT_POST,'crm',FILTER_SANITIZE_STRING);
        
        $this->validate->required(['nome','crm']);
        $errors = $this->validate->getErrors();

        if($errors){
            Flash::flashes($errors);
            return redirect($response,'/medicos/create');
        }

        $created = $this->medico->create(['nome' => $nome,'crm' => $crm]);
        if($created){
            Flash::set('message','Cadastrado com sucesso');
            return redirect($response,'/medicos/create');
        }
        Flash::set('message','Ocorreu um erro ao cadastrar o usuario');
        return redirect($response,'/medicos/create');
        
        return $response;
    }

    public function edit($request,$response,$args){
        $id = filter_var($args['id'],FILTER_SANITIZE_NUMBER_INT);

        $medico = $this->medico->findBy('id',$id);

        if(!$medico){
            Flash::set('message','Usuário inexistente', 'danger');
            return redirect($response,'/');
        }

        $messages = Flash::getAll();

        return $this->getTwig()->render($response,$this->setView('site/medico_edit'),[
            'title' => 'User edit',
            'medico' => $medico,
            'messages' => $messages
        ]);
    }

    public function update($request,$response,$args){
        
        $nome = filter_input(INPUT_POST,'nome',FILTER_SANITIZE_STRING);
        $crm = filter_input(INPUT_POST,'crm',FILTER_SANITIZE_STRING);
        $id = filter_var($args['id'],FILTER_SANITIZE_NUMBER_INT);
        

        $this->validate->required(['nome','crm']);
        $errors = $this->validate->getErrors();

        if($errors){
            Flash::flashes($errors);
            return redirect($response,'/medicos/edit/'.$id);
        }

        $updated = $this->medico->update(['fields' =>['nome' => $nome,'crm' => $crm],'where' => ['id' => $id]]);

        if($updated){
            Flash::set('message','Atualizado com sucesso');
            return redirect($response,'/medicos/edit/' . $id);
        }
        Flash::set('message','Erro ao atualizar','danger');
        return redirect($response,'/medicos/edit/' . $id);

    }
    public function destroy($request,$response,$args){
        $id = filter_var($args['id'],FILTER_SANITIZE_NUMBER_INT);
        
        $medico = $this->medico->findBy('id',$id);

        if(!$medico){
            Flash::set('message','Medico     inexistente', 'danger');
            return redirect($response,'/');
        }

        $deleted = $this->medico->delete('id',$id);
        
        if($deleted){
            Flash::set('message','Deletado com sucesso');
            return redirect($response,'/medicos');
        }
        Flash::set('message','Erro ao deletar','danger');
        return redirect($response,'/medicos' );

    }

    public function list($request,$response,$args){
        $medicos = $this->medico->find();
        $message = Flash::get('message');

        return $this->getTwig()->render($response,$this->setView('site/medicos'),[
            'title' => 'Medicos',
            'medicos' => $medicos,
            'message' => $message
        ]);

    }
}