<?php

class SyNT {
  public $code;
  public $message;
  public $data;

  function __construct($code, $message, $data) {
    $this->code = (int) $code;
    $this->message = $message;
    $this->data = $data;
    $this->set_response_code();
  }

  private function set_response_code() {
    http_response_code($this->code);
  }
}