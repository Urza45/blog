<?php

namespace Controller\Backend;

use \Lib\Controller;
use \Lib\Request;

class CommentController extends Controller
{
    public function list(Request $request)
    {        
        return $this->processReturn();
    }
    
    public function valid(Request $request, $vars)
    {
        $this->response = $this->manager->getManagerOf('Comments')->ban($vars['id_comment'], 0);
        return $this->processReturn();
    }

    public function ban(Request $request, $vars)
    {
        $this->response = $this->manager->getManagerOf('Comments')->ban($vars['id_comment'], 1);
        return $this->processReturn();
    }

    public function delete(Request $request, $vars)
    {
        if (isset($request->getParams()['action'])) {
            $this->response = $this->manager->getManagerOf('Comments')->delete($vars['id_comment']);
            return $this->processReturn();
        }

        $commentManager = $this->manager->getManagerOf('Comments');
        $comment = $commentManager->getUnique((int) $vars['id_comment']);

        return ['backend/commentDelete.html.twig', [
            'action' => '/admin/deletecomment-'.$vars['id_comment'],
            'Params' => $comment,
            'Response' => $this->response
            ]
        ]; 
    }

    private function processReturn()
    {
        $comments = $this->manager->getManagerOf('Comments')->getList();

        return ['backend/listcomment.html.twig', [
            'Response' => $this->response,
            'Comments' => $comments
            ]
        ];
    }

}