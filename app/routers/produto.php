<?php

use app\controllers\Produto;



require '../app/middlewares/logged.php';

$app->get('/produtos', Produto::class.':list');
$app->get('/produtos/create', Produto::class.':create')->add($logged);
$app->get('/produtos/edit/{id}', Produto::class.':edit')->add($logged);
$app->post('/produtos/store', Produto::class.':store');
$app->put('/produtos/update/{id}', Produto::class.':update');
$app->delete('/produtos/delete/{id}', Produto::class.':destroy')->add($logged);


