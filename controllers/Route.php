<?php
class Route {
  /*
   * Select the right Controller based on Route name.
   */

  public $route;

  function __construct($route, $args, $config) {
    $this->route = $route;
    $this->args = $args;
    $this->config = $config;
    $this->route();
    $this->clean();
  }

  function clean() {
    unset($this->config);
  }

  private function route() {
    switch ($this->route) {
      case 'site/new':
        $this->config->require_callback('NewInvite');
        $controller = new NewInvite($this->args, $this->config);
        break;
      case 'test':
        $this->config->require_callback('Test');
        $controller = new Test($this->args);
        break;
      default:
        $this->config->require_callback('DefaultRoute');
        $controller = new DefaultRoute;
        break;
    }
    $this->output = $controller->synt();
  }
}