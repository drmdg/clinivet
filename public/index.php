<?php

require "../bootstrap.php";

$app->get('/', 'app\controllers\site\HomeController:index');
$app->get('/musica/{id}', 'app\controllers\site\HomeController:musicaId');
$app->get('/cadastromusica', 'app\controllers\site\HomeController:cadastroMusica');
$app->post('/cadastromusica/store', 'app\controllers\site\HomeController:store');
$app->get('/guitarra', 'app\controllers\site\HomeController:guitarra');
$app->get('/violao', 'app\controllers\site\HomeController:violao');
$app->get('/bateria', 'app\controllers\site\HomeController:bateria');


$app->group('/admin', function () use ($app) {
	
});

$app->run();
