<?php
use Twilio\Rest\Client;

class NyTechTwilio {
  function __construct() {
    $this->twilio = new Client($_ENV['system']->twilio_sid, $_ENV['system']->twilio_token);
  }
}

