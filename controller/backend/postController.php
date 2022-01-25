<?php

namespace Controller\Backend;

use \Lib\Request;
use \Lib\Managers;
use \Lib\PDOFactory;

class PostController
{
    private $manager;

    public function __construct()
    {
        $this->manager = new Managers(PDOFactory::getMysqlConnexion());
    }

    public function index(Request $request)
    {
        $response = [];

        $postManager = $this->manager->getManagerOf('Post');
        $userManager = $this->manager->getManagerOf('User');

        return ['backend/listpost.html.twig', [
            'name' => 'Serge',
            'Posts' => $postManager->getListPost(),
            'Response' => $response
            ]
        ];
    }
    
    public function add(Request $request)
    {
        $response = [];

        return ['backend/addpost.html.twig', [
            'name' => 'Serge',
            'Params' => $request->getParams(),
            'Response' => $response
            ]
        ];
    }

    public function modify(Request $request, $vars)
    {

    }

    public function delete(Request $request)
    {

    }
}