<?php
// Allow requests from any origin
header('Content-Type: application/json');

// Allow cross-origin requests from specific domains (e.g., http://example.com)
header('Access-Control-Allow-Origin: https://superinfy.in');

// Specify allowed HTTP methods (e.g., GET, POST, OPTIONS)
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');

// Specify allowed headers, including 'x-requested-with'
header('Access-Control-Allow-Headers: Authorization, Content-Type, x-requested-with');

// Allow credentials (cookies or HTTP authentication)
header('Access-Control-Allow-Credentials: true');

// Check if a file was uploaded
if (isset($_FILES['image'])) {
    // Check for errors
    if ($_FILES['image']['error'] === 0) {
        // Define the upload directory
        // $uploadDirectory = '../../asset/blogImg/';
        // Generate a unique file name
        $fileExtension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $fileName = uniqid() . '.' . $fileExtension;
        $fileDestination = "../blogs/" . $fileName;

        // Move the uploaded file to the destination
        if (move_uploaded_file($_FILES['image']['tmp_name'], $fileDestination)) {
            // File upload successful
            $response = [
                "success" => 1,
                "file" => [
                    "url" => "https://images.superinfy.in/blogs/" . $fileName,
                ],
            ];

            echo json_encode($response);
        } else {
            // Error moving the file
            $response = [
                "success" => 0,
                "error" => "Failed to move the uploaded file.",
            ];

            echo json_encode($response);
        }
    } else {
        // Error with the uploaded file
        $response = [
            "success" => 0,
            "error" => "Error with the uploaded file. Error code: " . $_FILES['image']['error'],
        ];

        echo json_encode($response);
    }
} elseif (file_get_contents('php://input')) {
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
} else {
    // No file sent in the request
    $response = [
        "success" => 0,
        "error" => "No Image Recevied in Response!",
    ];

    echo json_encode($response);
}