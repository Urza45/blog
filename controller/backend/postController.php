<?php

namespace Controller\Backend;

use \Lib\Controller;
use \Lib\Request;
use \Lib\Security;
use \Model\Post;

class PostController extends Controller
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->security = Security::verifAccess($this->session, Security::ADMINISTRATOR_USER);
    }    
    
    /**
     * index
     *
     * @param  mixed $request
     * @return void
     */
    public function index(Request $request)
    {
        if ($this->security) {
            $postManager = $this->manager->getManagerOf('Post');

            return ['backend/listpost.html.twig', [
                'Posts' => $postManager->getListPost(),
                'Response' => $this->response
                ]
            ];
        }
        return ['error/403.html.twig', [] ];
    }
        
    /**
     * add
     *
     * @param  mixed $request
     * @return void
     */
    public function add(Request $request)
    {
        if ($this->security) {
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
        return ['error/403.html.twig', [] ];
    }
    
    /**
     * modify
     *
     * @param  mixed $request
     * @param  mixed $vars
     * @return void
     */
    public function modify(Request $request, $vars)
    {
        if ($this->security) {
            $post = $this->manager->getManagerOf('Post')->getUniquePost($vars['id_post']);

            return ['backend/post.html.twig', [
                'action' => 'modifypost',
                'Params' => $post,
                'Response' => $this->response
                ]
            ];
        }
        return ['error/403.html.twig', [] ];
    }
    
    /**
     * delete
     *
     * @param  mixed $request
     * @param  mixed $vars
     * @return void
     */
    public function delete(Request $request, $vars)
    {
        if ($this->security) {
            $this->response = $this->manager->getManagerOf('Post')->delete($vars['id_post']);
        
            $postManager = $this->manager->getManagerOf('Post');

            return ['backend/listpost.html.twig', [
                'Posts' => $postManager->getListPost(),
                'Response' => $this->response
                ]
            ];
        }
        return ['error/403.html.twig', [] ];
    }
}
