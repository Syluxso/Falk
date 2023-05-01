<?php

namespace notification;

use OptInRequest;
interface NotificationHandler {
    public function sendNotification(OptInRequest $optInRequest): bool;
}