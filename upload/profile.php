<?php
// Allow cross-origin requests from specific domains
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: https://superinfy.in/');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    // Check for errors
    if ($_FILES['image']['error'] === 0) {
        // Define the upload directory
        $uploadDirectory = '../profile/';

        // Generate a unique file name
        $fileExtension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $fileName = uniqid() . '.' . $fileExtension;
        $fileDestination = $uploadDirectory . $fileName;

        // Move the uploaded file to the destination
        if (move_uploaded_file($_FILES['image']['tmp_name'], $fileDestination)) {
            // File upload successful
            $response = [
                'imageUrl' => 'https://images.superinfy.in/profile/' . $fileName
            ];

            echo json_encode($response);
        } else {
            // Error moving the file
            $response = [
                'success' => 0,
                'error' => 'Failed to move the uploaded file.',
            ];

            echo json_encode($response);
        }
    } else {
        // Error with the uploaded file
        $response = [
            'success' => 0,
            'error' => 'Error with the uploaded file. Error code: ' . $_FILES['image']['error'],
        ];

        echo json_encode($response);
    }
} else {
    // No file sent in the request
    $response = [
        'success' => 0,
        'error' => 'No image received in the request.',
    ];

    echo json_encode($response);
}