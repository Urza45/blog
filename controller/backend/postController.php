<?php

namespace Controller\Backend;

use \Lib\Controller;
use \Lib\Request;
use \Lib\Managers;
use \Lib\PDOFactory;

class PostController extends Controller
{

    public function index(Request $request)
    {

        $postManager = $this->manager->getManagerOf('Post');
        $userManager = $this->manager->getManagerOf('User');

        var_dump($postManager->getListPost());

        return ['backend/listpost.html.twig', [
            'name' => 'Serge',
            'Posts' => $postManager->getListPost(),
            'Response' => $this->response
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