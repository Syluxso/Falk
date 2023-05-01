<?php

namespace notification\handlers;

use notification\NotificationHandler;
use OptInRequest;
use Twilio\Rest\Client;

class TwilioNotificationHandler implements NotificationHandler {
    private Client $client;
    private int $twilioPhone;

    public function __construct(Client $client, int $twilioPhone) {
        $this->client = $client;
        $this->twilioPhone = $twilioPhone;
    }

    public function sendNotification(OptInRequest $optInRequest): bool {
        $phone = $optInRequest->getPhone();
        $message = "Hello, this is a notification.";

        try {
            $this->client->messages->create(
                $phone,
                array(
                    'from' => $this->twilioPhone,
                    'body' => $message
                )
            );
            return true;
        } catch (\Exception $e) {
            // handle exception
            return false;
        }
    }
}