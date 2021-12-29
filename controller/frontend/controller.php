<?php

namespace Controller\Frontend;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

class Controller {

    public function __contruct() {
        
    }

    public function index() {
        $loader = new FilesystemLoader('../template');
        $twig = new Environment($loader, [
            'strict_variables' => true
        ]);

        $content = $twig->render('frontend/index.html.twig', ['name' => 'Fabien']);
        //var_dump($content);
        return $content;
    }
}