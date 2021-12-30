<?php
declare(strict_types=1);

namespace Controller\Backend;

class Controller 
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