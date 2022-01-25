<?php
declare(strict_types=1);

namespace Controller\Backend;

class MainController
{
    /**
     * Index function
     *
     * @return void
     */
    public function index()
    {
        return [ 'backend/index.html.twig', [] ];
    }
}