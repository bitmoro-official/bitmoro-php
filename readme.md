# Bitmoro PHP SDK

## Installation

Install the package using Composer:
```bash
composer require bitmoro/bitmorophp
```

Include the autoloader in your project:
```php
require __DIR__ . '/vendor/autoload.php';
```

## Usage

### Initialization
```php
$bitmoro = new Bitmoro("api_token", "defaultSenderId");
```
Get the API token and sender ID from the Bitmoro developer dashboard.

---

### OTP Message
Send a one-time password (OTP) message:
```php
$number = "1234567890";
$message = "Test Message";
$response = $bitmoro->sendOTP($number, $message);
```
If you want to change the sender ID:
```php
$response = $bitmoro->sendOTP($number, $message, $newSenderId);
```

#### Example of Success Response:
```json
{
    "numberOfFailed": 0,
    "messageId": "tqtkIYTQpSAneKYMLJEC"
}
```

#### Example of Error Response:
```json
{
    "message": "Cannot send message until the number is verified",
    "errorCode": "01"
}
```

---

### Bulk SMS
Send bulk SMS messages:
```php
$numbers = ["1234567890"];
$message = "Test Message";
$scheduleDate = time(); // Must be in timestamp
$callbackUrl = "call_back_url";
$response = $bitmoro->sendBulkSms($numbers, $message, $scheduleDate, $callbackUrl);
```
If you want to change the sender ID:
```php
$response = $bitmoro->sendBulkSms($numbers, $message, $scheduleDate, $callbackUrl, $newSenderId);
```

#### Request Body
| Field         | Type              | Validation                       | Required |
|---------------|-------------------|-----------------------------------|----------|
| number        | array of strings  | An array of valid phone numbers  | Yes      |
| message       | string            | The message content              | Yes      |
| senderId      | string            | Optional field for sender ID     | No       |
| scheduledDate | number            | Valid Unix timestamp in future   | No       |
| callbackUrl   | string            | Valid URL for message report     | No       |

#### Example Success Response:
```json
{
    "status": "QUEUED",
    "report": [
        {
            "number": "9801234567",
            "message": "Hello",
            "type": 1,
            "credit": 1
        },
        {
            "number": "9823456780",
            "message": "Hello",
            "type": 1,
            "credit": 1
        }
    ],
    "creditSpent": 2,
    "messageId": "s6atNQj8nTuAIxOrEv7w",
    "senderId": "bit_alert"
}
```

#### Example of Error Response:
```json
{
    "message": "Cannot send message until the number is verified",
    "errorCode": "01"
}
```

---

### Dynamic Message
Send dynamic messages:
```php
$contacts = [
    [
        "number" => "9842882495",
        "message" => "Hello, this is a test message",
        "city" => "Kathmandu",
        "country" => "Nepal",
        "to" => "9842882495"
    ],
    [
        "number" => "9869352017",
        "message" => "Hello, this is a test message",
        "city" => "Kathmandu",
        "country" => "Nepal",
        "to" => "9869352017"
    ]
];

$message = "${message} from ${country} to ${number} in ${city} ${to}";
$response = $bitmoro->sendDynamicSms($contacts, $message, $scheduleDate, $callbackUrl, $newSenderId);
```

#### Request Body
| Field           | Type              | Description                                                                         | Required |
|------------------|-------------------|-------------------------------------------------------------------------------------|----------|
| contacts         | array of objects  | Each contact object contains a number field and additional dynamic fields.          | Yes      |
| contacts.number  | string            | The phone number of the contact.                                                   | Yes      |
| message          | string            | Message body with placeholders `${key}` replaced by values from the contact object. | Yes      |
| senderId         | string            | The sender ID for the message.                                                     | No       |
| scheduledDate    | number            | Valid Unix timestamp in future.                                                    | No       |
| callbackUrl      | string            | Valid URL to receive message report.                                               | No       |
| defaultValues    | object            | Default key-value pairs for missing placeholders in dynamic messages.               | No       |

#### Example Success Response:
```json
{
    "status": "SCHEDULED",
    "report": [
        {
            "number": "9809876543",
            "message": "Hello joe. I am from Biratnagar",
            "type": 1,
            "credit": 1
        },
        {
            "number": "9800000000",
            "message": "Hello ramu. I am from Biratnagar",
            "type": 1,
            "credit": 1
        },
        {
            "number": "9876543210",
            "message": "Hello ramu. I am from kathmandu",
            "type": 1,
            "credit": 1
        }
    ],
    "creditSpent": 3,
    "messageId": "Fx2z80UJIm3BdlUrtb7I",
    "senderId": "bit_alert"
}
```

#### Example of Error Response:
```json
{
    "message": "Cannot send message until the number is verified",
    "errorCode": "01"
}
```


