<?php

namespace Controller\Backend;

use \Lib\Controller;
use \Lib\Request;
use \Lib\Managers;
use \Lib\PDOFactory;
use \Model\Post;

class PostController extends Controller
{

    public function index(Request $request)
    {

        $postManager = $this->manager->getManagerOf('Post');
        $userManager = $this->manager->getManagerOf('User');

        return ['backend/listpost.html.twig', [
            'Posts' => $postManager->getListPost(),
            'Response' => $this->response
            ]
        ];
    }
    
    public function add(Request $request)
    {
        $postManager = $this->manager->getManagerOf('Post');
        
        if (isset($request->getParams()['action'])) {
            $post = new Post();
            $post->hydrate($request->getParams());
            $post->setDateCreate(date('Y/m/d'));
            if ($request->getParams()['action'] == "newpost") {
                $post->setUser_idUser($this->session->getAttribute('idUser'));
            }
            $postManager->save($post);
            $this->response = [ 'type' => 'success', 'message' => 'Votre post a bien été enregistré.'];
            return ['backend/listpost.html.twig', [
                'Posts' => $postManager->getListPost(),
                'Response' => $this->response
                ]
            ];
        }
        
        return ['backend/post.html.twig', [
            'action' => 'newpost',
            'Params' => $request->getParams(),
            'Response' => $this->response
            ]
        ];
    }

    public function modify(Request $request, $vars)
    {
        $post = $this->manager->getManagerOf('Post')->getUniquePost($vars['id_post']);

        return ['backend/post.html.twig', [
            'action' => 'modifypost',
            'Params' => $post,
            'Response' => $this->response
            ]
        ];
    }

    public function delete(Request $request, $vars)
    {
        $this->response = $this->manager->getManagerOf('Post')->delete($vars['id_post']);
        
        $postManager = $this->manager->getManagerOf('Post');
        $userManager = $this->manager->getManagerOf('User');

        return ['backend/listpost.html.twig', [
            'Posts' => $postManager->getListPost(),
            'Response' => $this->response
            ]
        ];
    }
}