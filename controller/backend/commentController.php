<?php

namespace Controller\Backend;

use \Lib\Controller;
use \Lib\Request;
use \Lib\Security;

class CommentController extends Controller
{    
    /**
     * list
     *
     * @param  mixed $request
     * @return void
     */
    public function list(Request $request)
    {        
        if (Security::verifAccess($this->session, Security::MODERATOR_USER))
        {
            return $this->processReturn();
        }
        return ['error/403.html.twig', [] ];
        
    }
        
    /**
     * valid
     *
     * @param  mixed $request
     * @param  mixed $vars
     * @return void
     */
    public function valid(Request $request, $vars)
    {
        if (Security::verifAccess($this->session, Security::MODERATOR_USER))
        {
            $this->response = $this->manager->getManagerOf('Comments')->ban($vars['id_comment'], 0);
            return $this->processReturn();
        }
        return ['error/403.html.twig', [] ];
    }
    
    /**
     * ban
     *
     * @param  mixed $request
     * @param  mixed $vars
     * @return void
     */
    public function ban(Request $request, $vars)
    {
        if (Security::verifAccess($this->session, Security::MODERATOR_USER))
        {
            $this->response = $this->manager->getManagerOf('Comments')->ban($vars['id_comment'], 1);
            return $this->processReturn();
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
        if (Security::verifAccess($this->session, Security::MODERATOR_USER))
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
        return ['error/403.html.twig', [] ];
    }
    
    /**
     * processReturn
     *
     * @return void
     */
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