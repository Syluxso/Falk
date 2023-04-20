<?php

class Router {
  public $route;
  public $controller;
  public $get;
  public $post;

  function __construct($config) {
    $this->config = $config;
    $this->rout();
    $this->type();
    $this->payload();
    $this->controller();
    $this->clean();
    $this->output();
  }

  function clean() {
    unset($this->config);
  }

  private function rout() {
    $route = 'not-set';
    if(!empty($_GET['q'])) {
      $route = $_GET['q'];
    }
    $this->route = $route;
  }

  private function type() {
    $this->request_type = $_SERVER['REQUEST_METHOD'];
  }

  private function payload() {
    if(!empty($_GET)) {
      $this->get = $_GET;
    }
    if(!empty($_POST)) {
      $this->post = $_POST;
    }
  }

  private function controller() {
    if(!empty($this->route)) {
      $args = [
        'get' => $this->get,
        'post' => $this->post,
        'type' => $this->request_type,
      ];
      $this->config->require_controller('Route');
      $this->controller = new Route($this->route, $args, $this->config);
      $this->synt = $this->controller->output;
    }
  }

  public function output() {
    return json_encode($this->synt, JSON_PRETTY_PRINT);
  }
}