<?php

use app\controllers\Medico;
use app\controllers\User;
use Slim\Psr7\Response;


require '../app/middlewares/logged.php';

$app->get('/medicos', Medico::class.':list');
$app->get('/medicos/create', Medico::class.':create');
$app->get('/medicos/edit/{id}', Medico::class.':edit');
$app->post('/medicos/store', Medico::class.':store');
$app->put('/medicos/update/{id}', Medico::class.':update');
$app->delete('/medicos/delete/{id}', Medico::class.':destroy');


