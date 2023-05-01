<?php

namespace notification;

use OptInRequest;

require_once "NotificationHandler.php";
require_once "handlers/TwilioNotificationHandler.php";

class Notifier {
    private NotificationHandler $strategy;

    public function __construct(NotificationHandler $strategy) {
        $this->strategy = $strategy;
    }

    public function sendNotification(OptInRequest $optInRequest): bool {
        return $this->strategy->sendNotification($optInRequest);
    }
}