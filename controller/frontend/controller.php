<?php
declare(strict_types=1);

namespace Controller\Frontend;

class Controller 
{

    public function index()
    {
        return ['frontend/index.html.twig', ['name' => 'Serge']];
    }
}