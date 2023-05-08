<?php

/**
 * @var $config
 */

require_once("config.php");
require_once ("db/OptInRequestRepository.php");
require_once("core/model/OptInRequest.php");
require_once(__DIR__. '/../vendor/Twilio/autoload.php');
require_once("notification/Notifier.php");

use notification\handlers\TwilioNotificationHandler;
use notification\Notifier;
use Twilio\Rest\Client;

// DB Setup
$dbhandler = null;
try {
    if ($config["db_engine"] === "mysql") {
        $dbhandler = new db\handlers\OIRMySQLHandler($config);
    } else {
        $dbhandler = new db\handlers\OIRMSSQLHandler($config);
    }
} catch (Exception $e) {

}

$db = new \db\OptInRequestRepository($dbhandler);

// Twilio Setup

// Your Account SID and Auth Token from twilio.com/console
try{
    $client = new Client($config['twilio_sid'], $config['twilio_token']);
    $twilioNotificationHandler = new TwilioNotificationHandler($client, $config['twilio_phone'], $config['twilio_message'], $config['site_url']);
    $notifier = new Notifier($twilioNotificationHandler);
} catch (Exception $e){

}

