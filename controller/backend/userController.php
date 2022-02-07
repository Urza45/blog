<?php

namespace Controller\Backend;

use \Lib\Controller;
use \Lib\Request;
use \Lib\Security;

class UserController extends Controller
{    
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->security = Security::verifAccess($this->session, Security::SUPER_ADMIN_USER);
    }
    
    /**
     * list
     *
     * @param  mixed $request
     * @return void
     */
    public function list(Request $request)
    {
        if ($this->security)
        {
            $users = $this->manager->getManagerOf('User')->getListUser();
            $types = $this->manager->getManagerOf('TypeUser')->getListType();
            $nbComments = $this->manager->getManagerOf('Comments')->countByUser();

            return ['backend/listusers.html.twig', [
                    'Users' => $users,
                    'ListType' => $types,
                    'nbComments' => $nbComments
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
        if ($this->security)
        {
            $this->response = $this->manager->getManagerOf('User')->delete($vars['id_user']);

            $users = $this->manager->getManagerOf('User')->getListUser();
            $types = $this->manager->getManagerOf('TypeUser')->getListType();
            $nbComments = $this->manager->getManagerOf('Comments')->countByUser();

            return ['backend/listusers.html.twig', [
                    'Users' => $users,
                    'ListType' => $types,
                    'nbComments' => $nbComments,
                    'Response' => $this->response
                ] 
            ];
        }
        return ['error/403.html.twig', [] ];
    }
    
    /**
     * promote
     *
     * @param  mixed $request
     * @param  mixed $vars
     * @return void
     */
    public function promote(Request $request, $vars)
    {
        if ($this->security)
        {
            $this->response = $this->manager->getManagerOf('User')->promote($vars['id_user']);

            $users = $this->manager->getManagerOf('User')->getListUser();
            $types = $this->manager->getManagerOf('TypeUser')->getListType();
            $nbComments = $this->manager->getManagerOf('Comments')->countByUser();

            return ['backend/listusers.html.twig', [
                    'Users' => $users,
                    'ListType' => $types,
                    'nbComments' => $nbComments,
                    'Response' => $this->response
                ] 
            ];
        }
        return ['error/403.html.twig', [] ];
    }
    
    /**
     * demote
     *
     * @param  mixed $request
     * @param  mixed $vars
     * @return void
     */
    public function demote(Request $request, $vars)
    {
        if ($this->security)
        {
            $this->response = $this->manager->getManagerOf('User')->demote($vars['id_user']);

            $users = $this->manager->getManagerOf('User')->getListUser();
            $types = $this->manager->getManagerOf('TypeUser')->getListType();
            $nbComments = $this->manager->getManagerOf('Comments')->countByUser();

            return ['backend/listusers.html.twig', [
                    'Users' => $users,
                    'ListType' => $types,
                    'nbComments' => $nbComments,
                    'Response' => $this->response
                ] 
            ];
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
        if ($this->security)
        {
            $this->response = $this->manager->getManagerOf('User')->ban($vars['id_user']);

            $users = $this->manager->getManagerOf('User')->getListUser();
            $types = $this->manager->getManagerOf('TypeUser')->getListType();
            $nbComments = $this->manager->getManagerOf('Comments')->countByUser();

            return ['backend/listusers.html.twig', [
                    'Users' => $users,
                    'ListType' => $types,
                    'nbComments' => $nbComments,
                    'Response' => $this->response
                ] 
            ];
        }
        return ['error/403.html.twig', [] ];
    }
    
    /**
     * active
     *
     * @param  mixed $request
     * @param  mixed $vars
     * @return void
     */
    public function active(Request $request, $vars)
    {
        $this->response = $this->manager->getManagerOf('User')->active($vars['id_user']);

        $users = $this->manager->getManagerOf('User')->getListUser();
        $types = $this->manager->getManagerOf('TypeUser')->getListType();
        $nbComments = $this->manager->getManagerOf('Comments')->countByUser();

        return ['backend/listusers.html.twig', [
                'Users' => $users,
                'ListType' => $types,
                'nbComments' => $nbComments,
                'Response' => $this->response
            ] 
        ];
    }
}