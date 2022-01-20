<?php
declare(strict_types=1);

namespace Controller\Frontend;

use \Lib\Managers;
use \Lib\PDOFactory;
use \Lib\Request;
use \Lib\Utilities;

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
        $userManager = $this->manager->getManagerOf('User');

        return ['frontend/index.html.twig', [
                'LastPostList' => $postManager->getListPost(5),
                'ListUser' => $userManager->getListUser(),
                'salt' => Utilities::Salt(),
                'token' => Utilities::RandomToken()
            ]
        ];
    }

    public function list(Request $request) {
        $postManager = $this->manager->getManagerOf('Post');

        return ['frontend/list.html.twig', [
                'LastPostList' => $postManager->getListPost(),
                'Response' => $this->response,
                'Page' => $request->getUrl()
            ]
        ];
    }

    public function post(Request $request, $vars) {
        $postManager = $this->manager->getManagerOf('Post');
        $commentsManager = $this->manager->getManagerOf('Comments');
        $response = [];
        
        return ['frontend/post.html.twig', [
            'post' => $postManager->getUniquePost((int) $vars['id_post']),
            'comments' => $commentsManager->getListFromPost((int) $vars['id_post']),
            'vars' => $vars,
            'Response' => $response,
            'Page' => $request->getUrl()
            ]
        ];
    }

    public function register(Request $request) {
        return ['frontend/register.html.twig', ['name' => 'Serge']];
    }

    public function contact(Request $request) {
        //var_dump($request->getParams());
        $response = [];

        if (isset($request->getParams()['action']) && ($request->getParams()['action'] === 'sending'))
        {
            $email = new \Lib\MyMail;
            $response = $email->sendEmailToAdmin($request->getParams());
        }

        return ['frontend/contact.html.twig', [
            'name' => 'Serge',
            'Params' => $request->getParams(),
            'Response' => $response
            ]
        ];
    }
}