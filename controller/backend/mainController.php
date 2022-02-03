<?php
declare(strict_types=1);

namespace Controller\Backend;

use \Lib\Controller;
use \Lib\Security;

class MainController extends Controller
{
    /**
     * Index function
     *
     * @return void
     */
    public function index()
    {
        if (Security::verifAccess($this->session, Security::MODERATOR_USER))
        {
            return ['backend/index.html.twig', [] ];
        }
        return ['error/403.html.twig', [] ];
        /*
        if ($this->session->existsAttribute('admin')) {
            if (!in_array($this->session->getAttribute('admin'), ['2', '3', '4']))
            {
                return ['error/403.html.twig', [] ];
            }
            
        }
        return ['error/403.html.twig', [] ];
        */
    }
}