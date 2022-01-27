<?php
declare(strict_types=1);

namespace Controller\Backend;

use \Lib\Controller;

class MainController extends Controller
{
    /**
     * Index function
     *
     * @return void
     */
    public function index()
    {
        if ($this->session->existsAttribute('admin')) {
            if (!in_array($this->session->getAttribute('admin'), ['2', '3', '4']))
            {
                return ['error/forbidden.html.twig', [] ];
            }
            return ['backend/index.html.twig', [] ];
        }
        return ['error/forbidden.html.twig', [] ];
    }
}