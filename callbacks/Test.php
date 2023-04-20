<?php
require_once 'controllers/SyNT.php';

class Test {
  function __construct($args) {
    $this->code = 200;
    $this->message = 'Got your request and am returning your own args to you.';
    $this->data = $args;
  }

  public function synt() {
    return new SyNT($this->code, $this->message, $this->data);
  }
}