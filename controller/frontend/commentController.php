<?php

namespace Controller\Frontend;

use Lib\Controller;
use Lib\Request;
use Model\Comments;

class CommentController extends Controller
{
    /**
     * add
     *
     * @param  mixed $request
     * @return void
     */
    public function add(Request $request)
    {
        if ($this->session->existsAttribute('connected') <> 1) {
            return [
                'error/403.html.twig',
                [],
            ];
        }

        $commentManager = $this->manager->getManagerOf('Comments');

        if (isset($request->getParams()['action'])) {
            $comment = new Comments();
            $comment->hydrate($request->getParams());
            $commentManager->save($comment);

            $Params = new Comments();
            $Params->setDisabled('0');
            $Params->setPost_idPost($comment->getPost_idPost());
            $Params->setUser_idUser($this->session->getAttribute('idUser'));
            $Params->setDate(date('Y/m/d'));

            return [
                'frontend/post.html.twig',
                [
                    'post'     => $this->manager->getManagerOf('Post')->getUniquePost((int) $comment->getPost_idPost()),
                    'action'   => '/addcomment',
                    'comments' => $this->manager->getManagerOf('Comments')
                        ->getListFromPost((int) $comment->getPost_idPost()),
                    'Params'   => $Params,
                    'Response' => $this->response,
                    'Page'     => $request->getUrl(),
                ],
            ];
        }
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
        if ($this->session->existsAttribute('connected') <> 1) {
            return [
                'error/403.html.twig',
                [],
            ];
        }

        $commentManager = $this->manager->getManagerOf('Comments');

        if (isset($request->getParams()['action'])) {
            $comment = new Comments();
            $comment->hydrate($request->getParams());
            $commentManager->save($comment);

            return [
                'frontend/post.html.twig',
                [
                    'post'     => $this->manager->getManagerOf('Post')->getUniquePost((int) $comment->getPost_idPost()),
                    'action'   => '/addcomment',
                    'comments' => $this->manager->getManagerOf('Comments')
                        ->getListFromPost((int) $comment->getPost_idPost()),
                    'vars'     => $vars,
                    'Response' => $this->response,
                    'Page'     => $request->getUrl(),
                ],
            ];
        }

        $comment = $commentManager->getUnique((int) $vars['id_comment']);

        return [
            'frontend/commentForm.html.twig',
            [
                'action'   => '/modifycomment-' . $vars['id_comment'],
                'comment'  => $comment,
                'Params'   => $comment,
                'Response' => $this->response,
            ],
        ];
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
        if ($this->session->existsAttribute('connected') <> 1) {
            return [
                'error/403.html.twig',
                [],
            ];
        }

        if (isset($request->getParams()['action'])) {
            $this->response = $this->manager->getManagerOf('Comments')->delete($vars['id_comment']);
            $Params         = new Comments();
            $Params->setDisabled('0');
            $Params->setPost_idPost($request->getParams()['post_idPost']);
            $Params->setUser_idUser($this->session->getAttribute('idUser'));
            $Params->setDate(date('Y/m/d'));

            return [
                'frontend/post.html.twig',
                [
                    'post'     => $this->manager->getManagerOf('Post')
                        ->getUniquePost((int) $request->getParams()['post_idPost']),
                    'action'   => '/addcomment',
                    'comments' => $this->manager->getManagerOf('Comments')
                        ->getListFromPost((int) $request->getParams()['post_idPost']),
                    'Params'   => $Params,
                    'Response' => $this->response,
                    'Page'     => $request->getUrl(),
                ],
            ];
        }

        $commentManager = $this->manager->getManagerOf('Comments');
        $comment        = $commentManager->getUnique((int) $vars['id_comment']);

        return [
            'frontend/commentDelete.html.twig',
            [
                'action'   => '/deletecomment-' . $vars['id_comment'],
                'Params'   => $comment,
                'Response' => $this->response,
            ],
        ];
    }
}
