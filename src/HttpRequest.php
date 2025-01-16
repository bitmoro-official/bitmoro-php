<?php

namespace Bitmoro\Bitmorophp;

class HttpRequest
{
    public static function sendRequest($url, $token, $data)
    {
        $ch = curl_init();
        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $token",
            "Content-Type: application/json",
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        // Execute the request
        $response = curl_exec($ch);

        // Check for errors
        if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);

            // Return error response as JSON
            return json_encode([
                'status' => 'error',
                'message' => $error,
            ]);
        } else {
            // Decode the response
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            // Return success or failure based on HTTP code
            if ($httpCode >= 200 && $httpCode < 300) {
                return json_encode([
                    'status' => 'success',
                    'statusCode' => $httpCode,
                    'body' => json_decode($response, true), // Parse the JSON response
                ]);
            } else {
                return json_encode([
                    'status' => 'error',
                    'statusCode' => $httpCode,
                    'body' => json_decode($response, true), // Parse the JSON response
                ]);
            }
        }
    }
}
