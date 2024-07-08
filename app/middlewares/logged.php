<?php

namespace app\middlewares;
use Slim\Psr7\Response;

$logged = function ($request, $handler) {
    $response = $handler->handle($request);

  
    if (!isset($_SESSION['is_logged_in'])) {
        
        return redirect(new Response(), '/'); 
    }

    $existingContent = (string) $response->getBody();
    $modifiedResponse = new Response();
    $modifiedResponse->getBody()->write($existingContent);

    return $modifiedResponse;
};