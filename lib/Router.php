<?php

declare(strict_types=1);

namespace Lib;

use Lib\Request;
use Lib\Config;

/**
 * Router
 */
class Router
{
    private $routes = [];
    private static $instance;

    /**
     * La méthode statique qui permet d'instancier ou de récupérer l'instance unique
     **/
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Router();
        }
        return self::$instance;
    }

    /**
     * __construct
     *
     * @return void
     */
    private function __construct()
    {
        $xml = new \DOMDocument();
        $xml->load(__DIR__ . '/../config/routes.xml');
        $this->routes = $xml->getElementsByTagName('route');
    }

    /**
     * run
     *
     * @param  mixed $request
     * @return array
     */
    public function run(Request $request)
    {

        $config = Config::getInstance();

        $url = (preg_match("/\?/", $request->getUrl())) ? '/' . trim($request->getParams()['url'], '/') : '/'
            . trim($request->getUrl(), '/');

        // On parcourt les routes du fichier XML.
        foreach ($this->routes as $route) {
            $vars = [];

            $pattern = '`^' . $route->getAttribute('url') . '$`';
            $app = $route->getAttribute('app');
            $module = $route->getAttribute('module');
            $action = $route->getAttribute('action');

            if (preg_match($pattern, $url)) {
                // On regarde si des variables sont présentes dans l'URL.
                if ($route->hasAttribute('vars')) {
                    $varsNames = explode(',', $route->getAttribute('vars'));
                    $varsValues = explode('-', $url);

                    for ($i = 0; $i < count($varsNames); $i++) {
                        if (isset($varsValues[$i + 1])) {
                            $vars[$varsNames[$i]] = $varsValues[$i + 1];
                        }
                    }
                }

                /**
                * Controller initiation
                */
                $var = 'Controller' . DIRECTORY_SEPARATOR . $app . DIRECTORY_SEPARATOR . $module . 'Controller';
                if (is_file($config->get('directory') . DIRECTORY_SEPARATOR . lcfirst($var) . '.php')) {
                    $var = str_replace('/', '\\', $var);
                    $controller = new $var();
                    if (!empty($vars)) {
                        return $controller->$action($request, $vars);
                    }
                    return $controller->$action($request);
                }
                return ['error/404.html.twig', []];
            }
        }
        return ['error/404.html.twig', []];
    }
}
