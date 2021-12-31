<?php
declare(strict_types=1);

namespace Controller\Backend;

class MainController 
{

    public function index()
    {
        return [
            'backend/index.html.twig', 
            [
                'name' => 'Serge'
            ]
        ];
    }
}