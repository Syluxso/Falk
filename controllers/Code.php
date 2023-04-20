<?php

class Code {
  public $code;
  public $message;

  function __construct($code, $message = '') {
    $this->code = (int) $code;
    $this->message = $message;
    $this->set_responce_code();
    return $this;
  }

  private function set_responce_code() {
    http_response_code($this->code);
  }
}