<?php

class Config {
  function __construct() {
    $this->config();
    unset($this->config);
  }

  private function config() {
    $config_location = '/config/config.php';
    require_once(__DIR__ . '/config/config.php');
    $this->config = $config;
    if(empty($this->config['database']['db_host']) || empty($this->config['database']['db_name']) || empty($this->config['database']['db_user']) || empty($this->config['database']['db_pass'])) {
      echo 'Please enter your database configuration information at ' . $config_location; exit;
    } else {
      $this->db();
    }
    if(empty($this->config['twilio']['twilio_sid']) || empty($this->config['twilio']['twilio_token'])) {
      echo 'Please enter your twilio configuration information at ' . $config_location; exit;
    } else {
      $this->twilio();
    }
    if(empty($this->config['path']['twilio']) || empty($this->config['path']['root']) || empty($this->config['path']['controllers'])) {
      echo 'Please enter your path configuration information at ' . $config_location; exit;
    } else {
      $this->path();
    }
  }

  private function db() {
    $this->db_host = $this->get_setting('database', 'db_host');
    $this->db_name = $this->get_setting('database', 'db_name');
    $this->db_user = $this->get_setting('database', 'db_user');
    $this->db_pass = $this->get_setting('database', 'db_pass');
    $this->db_port = $this->get_setting('database', 'db_port');
  }

  private function twilio() {
    $this->twilio_sid = $this->get_setting('twilio', 'twilio_sid');
    $this->twilio_token = $this->get_setting('twilio', 'twilio_token');
    $this->twilio_phone = $this->get_setting('twilio', 'twilio_phone');
  }

  private function path() {
    $this->twilio         = $this->get_setting('path', 'twilio');
    $this->root           = $this->get_setting('path', 'root');
    $this->controllers    = $this->get_setting('path', 'controllers');
    $this->callbacks      = $this->get_setting('path', 'callbacks');
  }

  private function get_setting($group, $item) {
    return $this->config[$group][$item];
  }

  public function require_controller($controller) {
    require_once $this->controllers . $controller . '.php';
  }

  public function require_callback($callback) {
    require_once $this->callbacks . $callback . '.php';
  }
}
$config = new Config;

