<?php

$docroot = 'falk';

$config = [];

$config['database'] = [
  'db_host' => 'localhost',
  'db_name' => 'falk',
  'db_user' => 'drupal',
  'db_pass' => 'w33dman1',
  'db_port' => '',
];

$config['twilio'] = [
  'twilio_sid'   => 'ACa118d3170126c6499adcc3ab5d2c0f60',
  'twilio_token' => '376944ed7a2b3b7bb3bc161c765f0cc4',
  'twilio_phone' => '5592344502',
];

$config['path'] = [
  'root'        => $_SERVER['DOCUMENT_ROOT'] . '/' . $docroot . '/',
  'controllers' => $_SERVER['DOCUMENT_ROOT'] . '/' . $docroot . '/controllers/',
  'callbacks'   => $_SERVER['DOCUMENT_ROOT'] . '/' . $docroot . '/callbacks/',
  'twilio'      => $_SERVER['DOCUMENT_ROOT'] . '/' . $docroot . '/Twilio/autoload.php',
];

$config['status'] = false;