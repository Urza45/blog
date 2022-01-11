<?php
declare(strict_types=1);

namespace Lib;

use \Lib\Request;

class Router {

    private $routes = [];
    private static $_instance;

    /**
    * La méthode statique qui permet d'instancier ou de récupérer l'instance unique
    **/
    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new Router();
        }
        return self::$_instance;
    }

    private function __construct()
    {
        $xml = new \DOMDocument;
        $xml->load(__DIR__.'/../config/routes.xml');
        $this->routes = $xml->getElementsByTagName('route');
    }
    
    public function run(Request $request) {
    
        // $xml = new \DOMDocument;
        // $xml->load(__DIR__.'/../config/routes.xml');

        // $routes = $xml->getElementsByTagName('route');
        $params = $request->getParams();
        $url = '/' . trim($params['url'], '/');

        // On parcourt les routes du fichier XML.
        foreach ($this->routes as $route)
        {
            $vars = [];

            $pattern = '`^'.$route->getAttribute('url').'$`';
            $app = $route->getAttribute('app');
            $module = $route->getAttribute('module');
            $action = $route->getAttribute('action');

            if (preg_match($pattern, $url)) {
                // On regarde si des variables sont présentes dans l'URL.
                if ($route->hasAttribute('vars'))
                {    
                    $varsNames = explode(',', $route->getAttribute('vars'));
                    $varsValues = explode('-' , $url);

                    for ($i=0; $i<count($varsNames); $i++) {
                        if (isset($varsValues[$i+1])) {
                            $vars[$varsNames[$i]] = $varsValues[$i+1];
                        }
                    }
                }
                
                /**
                * Controller initiation 
                */
                $var = '\Controller\\' . $app . '\\' . $module . 'Controller';
                if (file_exists(dirname(__DIR__) . '/controller//' . $app . '//' . $module . 'Controller.php')) {
                    $controller = new $var();
                    if (!empty($vars)) {
                        return $controller->$action($vars);
                    }
                    return $controller->$action();
                }
                return ['error/404.html.twig', []];
            }       
        }
        return ['error/404.html.twig', []];
    }
}