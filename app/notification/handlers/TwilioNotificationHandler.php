<?php

namespace notification\handlers;

use notification\NotificationHandler;
use OptInRequest;
use Twilio\Rest\Client;

class TwilioNotificationHandler implements NotificationHandler {
    private Client $client;
    private int $twilioPhone;
    private string $message;
    private string $url;
    private string $siteName;

    public function __construct(Client $client, int $twilioPhone, string $message, string $url) {
        $this->client = $client;
        $this->twilioPhone = $twilioPhone;
        $this->message = $message;
        $this->url = $url;
    }

    public function sendNotification(OptInRequest $optInRequest): bool {
        $phone = $optInRequest->getPhone();
        $url = $this->buildOptInUrl($this->url, $optInRequest->getHash());
        $message = $this->buildMessage($optInRequest->getSiteName(), $url);

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

    private function buildMessage(string $siteName, string $url): string {
        return str_replace(array("{{SITE_NAME}}", "{{OPT_IN_URL}}"), array($siteName, $url), $this->message);
    }

    private function buildOptInUrl(string $url, string $hash): string {
        return $url.'optin.php?hash='.$hash;
    }
}