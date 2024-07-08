<?php

namespace app\controllers;

use app\classes\Flash;
use app\classes\Validate;
use app\database\models\User as ModelsUser;

class User extends Base{

    private $validate;
    private $user;

    public function __construct()
    {
        $this->validate = New Validate;
        $this->user = New ModelsUser;
    }

    public function create($request,$response,$args){
       
        $messages = Flash::getAll();

        return $this->getTwig()->render($response,$this->setView('site/user_create'),[
            'title' => 'User create',
            'messages' => $messages
        ]);
    }
    public function store($request,$response,$args){
        $nome = filter_input(INPUT_POST,'nome',FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST,'email',FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST,'password',FILTER_SANITIZE_STRING);

        $this->validate->required(['nome','email','password'])->exist($this->user,'email',$email);
        $errors = $this->validate->getErrors();

        if($errors){
            Flash::flashes($errors);
            return redirect($response,'/user/create');
        }

        $created = $this->user->create(['nome' => $nome,'email' => $email, 'password' => password_hash($password,PASSWORD_DEFAULT)]);
        if($created){
            Flash::set('message','Cadastrado com sucesso');
            return redirect($response,'/user/create');
        }
        Flash::set('message','Ocorreu um erro ao cadastrar o usuario');
        return redirect($response,'/user/create');
        
        return $response;
    }

    public function edit($request,$response,$args){
        $id = filter_var($args['id'],FILTER_SANITIZE_NUMBER_INT);

        $user = $this->user->findBy('id',$id);

        if(!$user){
            Flash::set('message','Usuário inexistente', 'danger');
            return redirect($response,'/');
        }

        $messages = Flash::getAll();

        return $this->getTwig()->render($response,$this->setView('site/user_edit'),[
            'title' => 'User edit',
            'user' => $user,
            'messages' => $messages
        ]);
    }

    public function update($request,$response,$args){
        
        $nome = filter_input(INPUT_POST,'nome',FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST,'email',FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST,'password',FILTER_SANITIZE_STRING);
        $id = filter_var($args['id'],FILTER_SANITIZE_NUMBER_INT);
        

        $this->validate->required(['nome','email','password']);
        $errors = $this->validate->getErrors();

        if($errors){
            Flash::flashes($errors);
            return redirect($response,'/user/edit/'.$id);
        }

        $updated = $this->user->update(['fields' =>['nome' => $nome,'email' => $email,'password' => password_hash($password,PASSWORD_DEFAULT)],'where' => ['id' => $id]]);

        if($updated){
            Flash::set('message','Atualizado com sucesso');
            return redirect($response,'/user/edit/' . $id);
        }
        Flash::set('message','Erro ao atualizar','danger');
        return redirect($response,'/user/edit/' . $id);

    }
    public function destroy($request,$response,$args){
        $id = filter_var($args['id'],FILTER_SANITIZE_NUMBER_INT);
        
        $user = $this->user->findBy('id',$id);

        if(!$user){
            Flash::set('message','Usuário inexistente', 'danger');
            return redirect($response,'/');
        }

        $deleted = $this->user->delete('id',$id);
        
        if($deleted){
            Flash::set('message','Deletado com sucesso');
            return redirect($response,'/');
        }
        Flash::set('message','Erro ao deletar','danger');
        return redirect($response,'/' );

    }
}