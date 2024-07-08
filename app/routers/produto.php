<?php

use app\controllers\Produto;



require '../app/middlewares/logged.php';

$app->get('/produtos', Produto::class.':list');
$app->get('/produtos/create', Produto::class.':create');
$app->get('/produtos/edit/{id}', Produto::class.':edit');
$app->post('/produtos/store', Produto::class.':store');
$app->put('/produtos/update/{id}', Produto::class.':update');
$app->delete('/produtos/delete/{id}', Produto::class.':destroy');


