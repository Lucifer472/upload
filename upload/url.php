<?php
// Allow requests from any origin
header('Content-Type: application/json');

// Allow cross-origin requests from specific domains (e.g., http://example.com)
header('Access-Control-Allow-Origin: https://superinfy.in/');

// Specify allowed HTTP methods (e.g., GET, POST, OPTIONS)
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');

// Specify allowed headers, including 'x-requested-with'
header('Access-Control-Allow-Headers: Authorization, Content-Type, x-requested-with');

// Allow credentials (cookies or HTTP authentication)
header('Access-Control-Allow-Credentials: true');

// Check if a file was uploaded
if (file_get_contents('php://input')) {
    $jsonData = file_get_contents('php://input');
    $requestData = json_decode($jsonData, true);
    if ($requestData['url'] == "") {
        $response = [
            "success" => 0,
            "error" => "Invalid Url!",
        ];
    } else {
        $response = [
            "success" => 1,
            "file" => [
                "url" => $requestData['url'],
            ],
        ];
    }
    echo json_encode($response);
}