<?php
declare(strict_types=1);

namespace Model;

class Router {

  private $app;
  private $url;
  
  public function __construct(string $app, string $url) {
    $this->app = $app;
    $this->url = $url;
  }

  public function run() {
    $var = "\controller\\" . $this->app . "\\controller";
    $controller = new $var();


    $vue = $controller->index();
    return $vue;
  }

}