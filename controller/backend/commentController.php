<?php

namespace Controller\Backend;

use Lib\Controller;
use Lib\Request;
use Lib\Security;

class CommentController extends Controller
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->security = Security::verifAccess($this->session, Security::MODERATOR_USER);
    }

    /**
     * list
     *
     * @param  mixed $request
     * @return void
     */
    public function list(Request $request)
    {
        if ($this->security) {
            return $this->processReturn();
        }
        return ['error/403.html.twig', [] ];
    }

    /**
     * valid
     *
     * @param  mixed $request
     * @param  mixed $vars
     * @return array $response[]
     */
    public function valid(Request $request, $vars)
    {
        if ($this->security) {
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
        if ($this->security) {
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
        if ($this->security) {
            if (isset($request->getParams()['action'])) {
                $this->response = $this->manager->getManagerOf('Comments')->delete($vars['id_comment']);
                return $this->processReturn();
            }

            $commentManager = $this->manager->getManagerOf('Comments');
            $comment = $commentManager->getUnique((int) $vars['id_comment']);

            return ['backend/commentDelete.html.twig', [
                'action' => '/admin/deletecomment-' . $vars['id_comment'],
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
     * @return mixed
     */
    private function processReturn()
    {
        return ['backend/listcomment.html.twig', [
            'Response' => $this->response,
            'Comments' => $this->manager->getManagerOf('Comments')->getList()
            ]
        ];
    }
}
