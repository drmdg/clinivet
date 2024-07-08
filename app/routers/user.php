<?php

use app\controllers\User;
use Slim\Psr7\Response;


require '../app/middlewares/logged.php';

$app->get('/user', User::class.':list');
$app->get('/user/create', User::class.':create')->add($logged);
$app->get('/user/edit/{id}', User::class.':edit')->add($logged);
$app->post('/user/store', User::class.':store');
$app->put('/user/update/{id}', User::class.':update');
$app->delete('/user/delete/{id}', User::class.':destroy')->add($logged);



