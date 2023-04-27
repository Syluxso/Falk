<?php
use Twilio\Rest\Client;

class SMSSend {
  function __construct($phone, $site_name, $opt_in_url, $config) {
    $this->phone = NyTechPhone::clean_phone($phone);
    $this->site_name = $site_name;
    $this->opt_in_url = $opt_in_url;
    $this->config = $config;
    require_once $this->config->twilio;

    $sid = $this->config->twilio_sid;
    $token = $this->config->twilio_token;
    $twilio = new Client($sid, $token);
    $twilio->messages->create('+1' . $this->phone, [
        "body" => 'Please select the link to opt in to ' . $this->site_name . '. ' . $this->opt_in_url,
        "from" => '+1' . $this->config->twilio_phone
      ]
    );
  }
}