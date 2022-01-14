<?php
declare(strict_types=1);

namespace Controller\Frontend;

class ConnexionController
{
    public function signin() {
    
        

        return ['frontend/register.html.twig', ['name' => 'Serge']];
    }

    public function signout() {
        return ['frontend/out.html.twig', ['name' => 'Serge']];
    }
}