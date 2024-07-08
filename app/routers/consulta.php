<?php

use app\controllers\Consulta;



require '../app/middlewares/logged.php';

$app->get('/consultas', Consulta::class.':list');
$app->get('/consultas/create', Consulta::class.':create');
$app->get('/consultas/edit/{id}', Consulta::class.':edit');
$app->post('/consultas/store', Consulta::class.':store');
$app->put('/consultas/update/{id}', Consulta::class.':update');
$app->delete('/consultas/delete/{id}', Consulta::class.':destroy');


