<?php

use app\controllers\Loja;



require '../app/middlewares/logged.php';

$app->get('/loja', Loja::class.':index');
$app->post('/loja/{id}', Loja::class.':efetuaCompra');
$app->get('/loja/carrinho', Loja::class.':carrinho');
$app->get('/loja/carrinho/delete/{id}', Loja::class.':carrinhoDeleteId');
$app->post('/loja/carrinho/finalizar', Loja::class.':finalizaCompra');


