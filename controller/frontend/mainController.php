<?php
declare(strict_types=1);

namespace Controller\Frontend;

use \Lib\Managers;
use \Lib\PDOFactory;
use \Lib\Request;
use \Lib\Utilities;
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
        $userManager = $this->manager->getManagerOf('User');

        $response = [];

        if (isset($request->getParams()['action']) && ($request->getParams()['action'] === 'sending'))
        {
            $email = new \Lib\MyMail;
            $response = $email->sendEmailToAdmin($request->getParams());
        }

        return ['frontend/index.html.twig', [
                'LastPostList' => $postManager->getListPost(5),
                'ListUser' => $userManager->getListUser(),
                'salt' => Utilities::Salt(),
                'token' => Utilities::RandomToken(),
                'Params' => $request->getParams(),
                'Response' => $response,
                'Page' => $request->getUrl()
            ]
        ];
    }

    public function list(Request $request) {

        $postManager = $this->manager->getManagerOf('Post');

        $response = [];

        return ['frontend/list.html.twig', [
                'LastPostList' => $postManager->getListPost(),
                'Response' => $response,
                'Page' => $request->getUrl()
            ]
        ];

        return ['frontend/list.html.twig', ['name' => 'Serge']];
    }

    public function post(Request $request, $vars) {

        $response = [];

        return ['frontend/post.html.twig', [
            'name' => 'Serge',
            'vars' => $vars,
            'Response' => $response,
            'Page' => $request->getUrl()
        ]];
    }

    public function register(Request $request) {

        $response = [];

        return ['frontend/register.html.twig', [
            'Response' => $response,
            'Page' => $request->getUrl()
            ]
        ];
    }

    public function contact(Request $request) {

        $response = [];

        if (isset($request->getParams()['action']) && ($request->getParams()['action'] === 'sending'))
        {
            $email = new \Lib\MyMail;
            $response = $email->sendEmailToAdmin($request->getParams());
        }

        return ['frontend/index.html.twig', [
            'Params' => $request->getParams(),
            'Response' => $response
            ]
        ];
    }
}