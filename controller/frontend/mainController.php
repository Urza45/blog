<?php
declare(strict_types=1);

namespace Controller\Frontend;

class MainController 
{

    public function index() {
        return ['frontend/index.html.twig', ['name' => 'Serge']];
    }

    public function list() {
        return ['frontend/list.html.twig', ['name' => 'Serge']];
    }

    public function post($vars) {
        return ['frontend/post.html.twig', [
            'name' => 'Serge',
            'vars' => $vars
        ]];
    }

    public function register() {
        return ['frontend/register.html.twig', ['name' => 'Serge']];
    }

    public function contact() {
        return ['frontend/contact.html.twig', ['name' => 'Serge']];
    }
}