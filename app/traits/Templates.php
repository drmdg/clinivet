<?php

namespace app\traits;

use app\classes\TwigFilters;
use app\classes\TwigGlobal;
use Slim\Views\Twig;

use Exception;
trait Templates{

    public function getTwig(){

        try{
            $twig = Twig::create(DIR_VIEWS);
            $twig->addExtension(new TwigFilters);
            TwigGlobal::load($twig);
            return $twig;
        }catch(Exception $e){
            var_dump($e->getMessage());
        }
    }

    public function setView($name){
        return $name.EXT_VIEWS;
    }
}