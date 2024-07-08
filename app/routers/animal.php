<?php

use app\controllers\Animal;



require '../app/middlewares/logged.php';

$app->get('/animals', Animal::class.':list');
$app->get('/animals/create', Animal::class.':create')->add($logged);
$app->get('/animals/edit/{id}', Animal::class.':edit')->add($logged);
$app->post('/animals/store', Animal::class.':store');
$app->put('/animals/update/{id}', Animal::class.':update');
$app->delete('/animals/delete/{id}', Animal::class.':destroy')->add($logged);


