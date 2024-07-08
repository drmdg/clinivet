<?php

namespace app\controllers;

use app\classes\Flash;
use app\classes\Validate;
use app\database\models\Produtos;

class Produto extends Base{

    private $validate;
    private $produto;

    public function __construct()
    {
        $this->validate = New Validate;
        $this->produto = New Produtos;
    }

    public function create($request,$response,$args){
       
        $messages = Flash::getAll();

        return $this->getTwig()->render($response,$this->setView('site/produto_create'),[
            'title' => 'Produto create',
            'messages' => $messages
        ]);
    }
    public function store($request,$response,$args){
        $codigo = filter_input(INPUT_POST,'codigo',FILTER_SANITIZE_STRING);
        $nome = filter_input(INPUT_POST,'nome',FILTER_SANITIZE_STRING);
        $descricao = filter_input(INPUT_POST,'descricao',FILTER_SANITIZE_STRING);
        $valor = filter_input(INPUT_POST,'valor',FILTER_SANITIZE_NUMBER_INT);

        $this->validate->required(['codigo','nome','descricao','valor']);
        $errors = $this->validate->getErrors();

        if($errors){
            Flash::flashes($errors);
            return redirect($response,'/produtos/create');
        }

        $created = $this->produto->create(['codigo' => $codigo,'nome' => $nome, 'descricao' => $descricao ,'valor' => $valor]);
        if($created){
            Flash::set('message','Cadastrado com sucesso');
            return redirect($response,'/produtos/create');
        }
        Flash::set('message','Ocorreu um erro ao cadastrar o produto');
        return redirect($response,'/produtos/create');
        
        return $response;
    }

    public function edit($request,$response,$args){
        $id = filter_var($args['id'],FILTER_SANITIZE_NUMBER_INT);

        $produto = $this->produto->findBy('id',$id);

        if(!$produto){
            Flash::set('message','Produto inexistente', 'danger');
            return redirect($response,'/produtos');
        }

        $messages = Flash::getAll();

        return $this->getTwig()->render($response,$this->setView('site/produto_edit'),[
            'title' => 'Produto edit',
            'produto' => $produto,
            'messages' => $messages
        ]);
    }

    public function update($request,$response,$args){
        $codigo = filter_input(INPUT_POST,'codigo',FILTER_SANITIZE_STRING);
        $nome = filter_input(INPUT_POST,'nome',FILTER_SANITIZE_STRING);
        $descricao = filter_input(INPUT_POST,'descricao',FILTER_SANITIZE_STRING);
        $valor = filter_input(INPUT_POST,'valor',FILTER_SANITIZE_NUMBER_INT);
        $id = filter_var($args['id'],FILTER_SANITIZE_NUMBER_INT);


        $this->validate->required(['codigo','nome','descricao','valor']);
        $errors = $this->validate->getErrors();

        if($errors){
            Flash::flashes($errors);
            return redirect($response,'/produtos/edit/'.$id);
        }

        $updated = $this->produto->update(['fields' =>['codigo' => $codigo,'nome' => $nome,'descricao' => $descricao,'valor' => $valor],'where' => ['id' => $id]]);

        if($updated){
            Flash::set('message','Atualizado com sucesso');
            return redirect($response,'/produtos/edit/' . $id);
        }
        Flash::set('message','Erro ao atualizar','danger');
        return redirect($response,'/produtos/edit/' . $id);

    }
    public function destroy($request,$response,$args){
        $id = filter_var($args['id'],FILTER_SANITIZE_NUMBER_INT);
        
        $consulta = $this->produto->findBy('id',$id);

        if(!$consulta){
            Flash::set('message','Produto inexistente', 'danger');
            return redirect($response,'/');
        }

        $deleted = $this->produto->delete('id',$id);
        
        if($deleted){
            Flash::set('message','Deletado com sucesso');
            return redirect($response,'/produtos');
        }
        Flash::set('message','Erro ao deletar','danger');
        return redirect($response,'/produtos' );

    }

    public function list($request,$response,$args){
        $produtos= $this->produto->find();
        
        $message = Flash::get('message');
        return $this->getTwig()->render($response,$this->setView('site/produtos'),[
            'title' => 'Produtos',
            'produtos' => $produtos,
            'message' => $message
        ]);

    }
}