<?php
require_once 'Twilio/autoload.php';
use Twilio\Rest\Client;

class NewInvite {
  function __construct($config) {
    $twilio = new Client($config->twilio_sid, $config->twilio_token);
    $phone_number = $twilio->lookups->v2->phoneNumbers("+15596182704")
      ->fetch();
  }
}