<?php
declare(strict_types=1);

namespace Controller\Backend;

use \Lib\Controller;
use \Lib\Security;

class MainController extends Controller
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
     * Index function
     *
     * @return void
     */
    public function index()
    {
        //if (Security::verifAccess($this->session, Security::MODERATOR_USER))
        if ($this->security) {
            return ['backend/index.html.twig', [] ];
        }
        return ['error/403.html.twig', [] ];
    }
}
