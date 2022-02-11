<?php

namespace Lib;

use Twig\Extra\Intl\IntlExtension;
use Lib\Session;

class MyTwig
{
    private $twig;

    /**
     * __construct
     *
     * @param  mixed $session
     * @return void
     */
    public function __construct(SESSION $session)
    {
        $config = Config::getInstance();

        //var_dump($config);
        /**
        * Twig initiation
        */
        $loader = new \Twig\Loader\FilesystemLoader($config->get('directory') . '/template');
        $this->twig = new \Twig\Environment(
            $loader,
            [
                'debug' => true,
                'cache' => false,
            ]
        );
        /**
        * Add Twig extension for debugging
        */
        $this->twig->addExtension(new \Twig\Extension\DebugExtension());
        /**
        * Add Twig extension for format date functions
        */
        $this->twig->addExtension(new IntlExtension());
        /**
        * Allow twig to access the session
        */
        if ($session->existSession()) {
            $this->twig->addGlobal('session', $_SESSION);
        }
    }

    public function getRender(array $view)
    {
        ob_start();
            print_r($this->twig->render($view[0], $view[1]));
        ob_end_flush();
    }
}
