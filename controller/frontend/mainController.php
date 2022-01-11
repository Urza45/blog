<?php
declare(strict_types=1);

namespace Controller\Frontend;

use \Lib\Managers;
use Lib\PDOFactory;
use \Model\Post;

class MainController 
{

    public function index() {
        $manager = new Managers(PDOFactory::getMysqlConnexion());
        $postManager = $manager->getManagerOf('Post');

        return ['frontend/index.html.twig', [
                'LastPostList' => $postManager->getListPosts(5)
            ]
        ];
    }

    public function list() {
        $manager = new Managers(PDOFactory::getMysqlConnexion());
        $postManager = $manager->getManagerOf('Post');

        return ['frontend/index.html.twig', [
                'LastPostList' => $postManager->getListPosts()
            ]
        ];

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