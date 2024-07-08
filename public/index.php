<?php

session_start();

use app\classes\TwigGlobal;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Middleware\MethodOverrideMiddleware;

require '../vendor/autoload.php';
require __DIR__ . '/../vendor/autoload.php';


$app = AppFactory::create();

TwigGlobal::set('logged_in',$_SESSION['is_logged_in'] ?? '');
TwigGlobal::set('user',$_SESSION['user_logged_data'] ?? '');

require '../app/routers/site.php';
require '../app/routers/user.php';
require '../app/routers/medico.php';
require '../app/routers/animal.php';
require '../app/routers/consulta.php';
require '../app/routers/venda.php';
require '../app/routers/produto.php';

$methodOverrideMiddleware= new MethodOverrideMiddleware;
$app->add($methodOverrideMiddleware);

$app->map(['GET','PUT','POST','DELETE','PATCH'], '/{routes:.+}',function($request,$response){
    $response->getBody()->write('Something wrong');
    return $response;
});


$app->run();