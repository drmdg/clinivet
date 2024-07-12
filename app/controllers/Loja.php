<?php

namespace app\controllers;

use app\classes\Flash;
use app\database\models\ProdutoQuantidade;
use app\database\models\Produtos;
use app\database\models\Vendas;

class Loja extends Base{

    private $produto;
    private $venda;
    private $pqtd;

    public function __construct()
    {
        $this->produto = new Produtos;
        $this->venda = new Vendas;
        $this->pqtd = new ProdutoQuantidade;
    }

    public function index($request,$response){

        $messages = Flash::getAll();
        $produtos= $this->produto->find();

        return $this->getTwig()->render($response,$this->setView('site/loja'),[
            'title' => 'Loja',
            'messages' => $messages,
            'produtos' => $produtos
        ]);
    }

    public function efetuaCompra($request,$response,$args){
        $id = filter_var($args['id'],FILTER_SANITIZE_NUMBER_INT);
        $itemsNumber = filter_var($_POST['itemsNumber'.$id],FILTER_SANITIZE_NUMBER_INT);
        $itemsNumber = intval($itemsNumber);

        $produtoComprado= $this->produto->findBy('id',$id);
        $vendaIncompleta = $this->venda->findVendaIncompletaByIdUser($_SESSION['user_logged_data']['id']);
        $valorTotal = $produtoComprado->valor * $itemsNumber;

        if($vendaIncompleta){
            $this->pqtd->create(['quantidade' => $itemsNumber,'valor_total' => $valorTotal,'produto_id' => $id,'venda_id' => $vendaIncompleta->id]);
            $this->venda->update(['fields' =>['valor_total' => $vendaIncompleta->valor_total + $valorTotal],'where' => ['id' => $vendaIncompleta->id]]);
        }else{
            $this->venda->create(['status_venda' => 0,'valor_total' => 0,'id_cliente' => $_SESSION['user_logged_data']['id']]);
            $vendaIncompleta = $this->venda->findVendaIncompletaByIdUser($_SESSION['user_logged_data']['id']);
            $this->pqtd->create(['quantidade' => $itemsNumber,'valor_total' => $valorTotal,'produto_id' => $id,'venda_id' => $vendaIncompleta->id]);
            $this->venda->update(['fields' =>['valor_total' => $vendaIncompleta->valor_total + $valorTotal],'where' => ['id' => $vendaIncompleta->id]]);
        }


        return redirect($response,'/loja');
        
    }

    public function carrinho($request,$response){

        $vendas= $this->venda->findVendaIncompletaByIdUser($_SESSION['user_logged_data']['id']);
        $pqtd = $this->pqtd->find();
        $message = Flash::get('message');

        $pqtdfiltered =  [];
        foreach ($pqtd as $pq) {
            if ($pq->venda_id == $vendas->id) {
                $pqtdfiltered[] = $pq;
            }
        }

        return $this->getTwig()->render($response,$this->setView('site/carrinho'),[
            'title' => 'Clientes',
            'vendas' => $vendas,
            'message' => $message,
            'pqtd' =>  $pqtdfiltered
        ]);
    }

    public function carrinhoDeleteId($request,$response,$args){
        $id = filter_var($args['id'],FILTER_SANITIZE_NUMBER_INT);
        $vendas= $this->venda->findVendaIncompletaByIdUser($_SESSION['user_logged_data']['id']);
        
        $message = Flash::get('message');

        $this->pqtd->delete('id',$id);
        $pqtd = $this->pqtd->find();
        $pqtdfiltered =  [];
        foreach ($pqtd as $pq) {
            if ($pq->venda_id == $vendas->id) {
                $pqtdfiltered[] = $pq;
            }
        }

        return $this->getTwig()->render($response,$this->setView('site/carrinho'),[
            'title' => 'Clientes',
            'vendas' => $vendas,
            'message' => $message,
            'pqtd' =>  $pqtdfiltered
        ]);
    }

    public function finalizaCompra($request,$response){
        $vendas= $this->venda->findVendaIncompletaByIdUser($_SESSION['user_logged_data']['id']);
        
        $message = Flash::get('message');

        $this->venda->update(['fields' =>['status_venda' => 1],'where' => ['id' => $vendas->id]]);

        return $this->getTwig()->render($response,$this->setView('site/sucesso'),[
            'title' => 'Sucesso',
            'message' => $message
        ]);
    }

}