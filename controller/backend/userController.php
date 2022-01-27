<?php

namespace Controller\Backend;

use \Lib\Controller;
use \Lib\Request;

class UserController extends Controller
{
    public function list(Request $request)
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

    public function delete(Request $request, $vars)
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

    public function promote(Request $request, $vars)
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

    public function demote(Request $request, $vars)
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

    public function ban(Request $request, $vars)
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
}