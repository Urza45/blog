<?php
declare(strict_types=1);

namespace Controller\Frontend;

use \Lib\Controller;
use \Lib\Managers;
use \Lib\PDOFactory;
use \Lib\Request;
use \Lib\Utilities;
use \Model\Post;

class MainController extends Controller
{    
    /**
     * index
     *
     * @param  mixed $request
     * @return void
     */
    public function index(Request $request) {

        $postManager = $this->manager->getManagerOf('Post');
        $userManager = $this->manager->getManagerOf('User');

        if (isset($request->getParams()['action']) && ($request->getParams()['action'] === 'sending'))
        {
            $email = new \Lib\MyMail;
            $this->response = $email->sendEmailToAdmin($request->getParams());
        }

        return ['frontend/index.html.twig', [
                'LastPostList' => $postManager->getListPost(5),
                'Response' => $this->response,
                'Page' => $request->getUrl()
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

        return ['frontend/post.html.twig', [
            'post' => $postManager->getUniquePost((int) $vars['id_post']),
            'vars' => $vars,
            'Response' => $this->response,
            'Page' => $request->getUrl()
            ]
        ];
    }

    public function register(Request $request) {

        return ['frontend/register.html.twig', [
            'Response' => $this->response,
            'Page' => $request->getUrl()
            ]
        ];
    }

    public function contact(Request $request) {

        if (isset($request->getParams()['action']) && ($request->getParams()['action'] === 'sending'))
        {
            $email = new \Lib\MyMail;
            $this->response = $email->sendEmailToAdmin($request->getParams());
        }

        return ['frontend/index.html.twig', [
            'Params' => $request->getParams(),
            'Response' => $this->response
            ]
        ];
    }
}