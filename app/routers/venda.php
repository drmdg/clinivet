<?php

use app\controllers\Venda;



require '../app/middlewares/logged.php';

$app->get('/vendas', Venda::class.':list');
$app->delete('/vendas/delete/{id}', Venda::class.':destroy');


