<?php
declare(strict_types=1);

namespace Model;

use \Model\Request;

class Router {

    public static function run(Request $request) {
    
        $xml = new \DOMDocument;
        $xml->load(__DIR__.'/../config/routes.xml');

        $routes = $xml->getElementsByTagName('route');
        $params = $request->getParams();
        $url = '/'.trim($params['url'], '/');

        // On parcourt les routes du fichier XML.
        foreach ($routes as $route)
        {
            $vars = [];

            // On regarde si des variables sont présentes dans l'URL.
            if ($route->hasAttribute('vars'))
            {    
                $vars = explode(',', $route->getAttribute('vars'));
            }

            $pattern = '`^'.$route->getAttribute('url').'$`';
            $app = $route->getAttribute('app');
            $module = $route->getAttribute('module');
            $action = $route->getAttribute('action');
        
            if (preg_match($pattern, $url)) {
                /**
                * Controller initiation 
                */
                $var = '\Controller\\' . $app . '\\' . $module . 'Controller';
                $controller = new $var();
                if (!empty($vars)) {
                    return $controller->$action($vars);
                }
                return $controller->$action();
            }       
        }
        return ['error/404.html.twig', []];
    }
}