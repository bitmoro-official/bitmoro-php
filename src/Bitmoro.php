<?php

namespace Bitmoro\Bitmorophp;

use stdClass;

class Bitmoro extends HttpRequest
{
    private $apiToken;
    private $senderId;

    public function __construct($apiToken, $senderId)
    {
        $this->apiToken = $apiToken;
        $this->senderId = $senderId;
    }

    public function getApiToken()
    {
        return $this->apiToken;
    }

    public function getSenderId()
    {
        return $this->senderId;
    }

    public function sendOTP(array $numbers, string $message, $newSenderId = null)
    {
        $url = "https://bitmoro.com/api/message/api";
        $token = $this->getApiToken();
        $senderId = $newSenderId ?? $this->getSenderId();
        // Request payload
        $data = [
            "number" => $numbers,
            "message" => $message,
            "senderId" => $senderId
        ];
        $response = $this->sendRequest($url, $token, $data);
        return $response;
    }

    public function sendBulkSms(array $numbers, string $message, $scheduledDate = null, $callbackUrl = null, $newSenderId = null)
    {
        $url = "https://bitmoro.com/api/message/bulk-api";
        $token = $this->getApiToken();
        $senderId = $newSenderId ?? $this->getSenderId();
        // Request payload
        $data = [
            "number" => $numbers,
            "message" => $message,
            "scheduledDate" => $scheduledDate,
            "callbackUrl" => $callbackUrl,
            "senderId" => $senderId
        ];
        $response = $this->sendRequest($url, $token, $data);
        return $response;
    }

    public function sendDynamicSms(array $contacts, string $message, $scheduledDate = null, $callbackUrl = null, $defaultValues = [], $newSenderId = null)
    {
        $url = "https://bitmoro.com/api/message/dynamic-api";
        $token = $this->getApiToken();
        $senderId = $newSenderId ?? $this->getSenderId();
        // Request payload
        $data = [
            "contacts" => $contacts,
            "message" => $message,
            "scheduledDate" => $scheduledDate,
            "callbackUrl" => $callbackUrl,
            "senderId" => $senderId,
        ];
        if (!empty($defaultValues)) {
            $defaultValueObject = new stdClass();
            foreach ($defaultValues as $key => $value) {
                $defaultValueObject->$key = $value;
            }
            $data['defaultValues'] = $defaultValueObject;
        }
        $response = $this->sendRequest($url, $token, $data);

        return $response;
    }
}
