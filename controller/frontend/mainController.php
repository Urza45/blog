<?php
declare(strict_types=1);

namespace Controller\Frontend;

class MainController 
{

    public function index()
    {
        return ['frontend/index.html.twig', ['name' => 'Serge']];
    }
}