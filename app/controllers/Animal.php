<?php

namespace app\controllers;

use app\classes\Flash;
use app\classes\Validate;
use app\database\models\Animals;

class Animal extends Base{

    private $validate;
    private $animal;

    public function __construct()
    {
        $this->validate = New Validate;
        $this->animal = New Animals;
    }

    public function create($request,$response,$args){
       
        $messages = Flash::getAll();

        return $this->getTwig()->render($response,$this->setView('site/animal_create'),[
            'title' => 'Animal create',
            'messages' => $messages
        ]);
    }
    public function store($request,$response,$args){
        $nome = filter_input(INPUT_POST,'nome',FILTER_SANITIZE_STRING);
        $data_nascimento = $_POST['data_nascimento'];
        $especie = filter_input(INPUT_POST,'especie',FILTER_SANITIZE_STRING);
        $raca = filter_input(INPUT_POST,'raca',FILTER_SANITIZE_STRING);
        $id_dono = $_POST['id_dono'];


        $this->validate->required(['nome','data_nascimento','especie','raca','id_dono']);
        $errors = $this->validate->getErrors();

        if($errors){
            Flash::flashes($errors);
            return redirect($response,'/animals/create');
        }

        $created = $this->animal->create(['nome' => $nome,'data_nascimento' => $data_nascimento, 'especie' => $especie , 'raca' => $raca , 'id_dono' => $id_dono]);
        if($created){
            Flash::set('message','Cadastrado com sucesso');
            return redirect($response,'/animals/create');
        }
        Flash::set('message','Ocorreu um erro ao cadastrar o animal');
        return redirect($response,'/animals/create');
        
        return $response;
    }

    public function edit($request,$response,$args){
        $id = filter_var($args['id'],FILTER_SANITIZE_NUMBER_INT);

        $animal = $this->animal->findBy('id',$id);

        if(!$animal){
            Flash::set('message','Animal inexistente', 'danger');
            return redirect($response,'/animals');
        }

        $messages = Flash::getAll();

        return $this->getTwig()->render($response,$this->setView('site/animal_edit'),[
            'title' => 'Animal edit',
            'animal' => $animal,
            'messages' => $messages
        ]);
    }

    public function update($request,$response,$args){
        $nome = filter_input(INPUT_POST,'nome',FILTER_SANITIZE_STRING);
        $data_nascimento = $_POST['data_nascimento'];
        $especie = filter_input(INPUT_POST,'especie',FILTER_SANITIZE_STRING);
        $raca = filter_input(INPUT_POST,'raca',FILTER_SANITIZE_STRING);
        $id_dono = $_POST['id_dono'];
        $id = filter_var($args['id'],FILTER_SANITIZE_NUMBER_INT);


        $this->validate->required(['nome','data_nascimento','especie','raca','id_dono']);
        $errors = $this->validate->getErrors();

        if($errors){
            Flash::flashes($errors);
            return redirect($response,'/animals/edit/'.$id);
        }

        $updated = $this->animal->update(['fields' =>['nome' => $nome,'data_nascimento' => $data_nascimento,'especie' => $especie,'raca' => $raca, 'id_dono' => $id_dono ],'where' => ['id' => $id]]);

        if($updated){
            Flash::set('message','Atualizado com sucesso');
            return redirect($response,'/animals/edit/' . $id);
        }
        Flash::set('message','Erro ao atualizar','danger');
        return redirect($response,'/animals/edit/' . $id);

    }
    public function destroy($request,$response,$args){
        $id = filter_var($args['id'],FILTER_SANITIZE_NUMBER_INT);
        
        $animal = $this->animal->findBy('id',$id);

        if(!$animal){
            Flash::set('message','Animal inexistente', 'danger');
            return redirect($response,'/');
        }

        $deleted = $this->animal->delete('id',$id);
        
        if($deleted){
            Flash::set('message','Deletado com sucesso');
            return redirect($response,'/animals');
        }
        Flash::set('message','Erro ao deletar','danger');
        return redirect($response,'/animals' );

    }

    public function list($request,$response,$args){
        $users = $this->animal->find();
        
        $message = Flash::get('message');

        return $this->getTwig()->render($response,$this->setView('site/animals'),[
            'title' => 'Clientes',
            'animals' => $users,
            'message' => $message
        ]);

    }
}