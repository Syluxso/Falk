<?php
require_once 'controllers/SyNT.php';

class DefaultRoute {
  public $code;
  public $message;
  public $data;

  function __construct() {
    $this->code = 400;
    $this->message = 'Not a recognized endpoint.';
    $this->data = ['error' => $this->message];
  }

  public function synt() {
    return new SyNT($this->code, $this->message, ['error' => $this->message]);  }
}