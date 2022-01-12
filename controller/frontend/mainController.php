<?php
declare(strict_types=1);

namespace Controller\Frontend;

use \Lib\Managers;
use \Lib\PDOFactory;
use \Lib\Request;
use \Model\Post;

class MainController 
{
    private $manager;

    public function __construct()
    {
        $this->manager = new Managers(PDOFactory::getMysqlConnexion());
    }
    
    /**
     * index
     *
     * @param  mixed $request
     * @return void
     */
    public function index(Request $request) {

        $postManager = $this->manager->getManagerOf('Post');

        return ['frontend/index.html.twig', [
                'LastPostList' => $postManager->getListPost(5)
            ]
        ];
    }

    public function list(Request $request) {
        $manager = new Managers(PDOFactory::getMysqlConnexion());
        $postManager = $manager->getManagerOf('Post');

        return ['frontend/list.html.twig', [
                'LastPostList' => $postManager->getListPost()
            ]
        ];

        return ['frontend/list.html.twig', ['name' => 'Serge']];
    }

    public function post(Request $request, $vars) {
        return ['frontend/post.html.twig', [
            'name' => 'Serge',
            'vars' => $vars
        ]];
    }

    public function register(Request $request) {
        return ['frontend/register.html.twig', ['name' => 'Serge']];
    }

    public function contact(Request $request) {
        return ['frontend/contact.html.twig', ['name' => 'Serge']];
    }
}