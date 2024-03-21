<?php

require 'validate_token.php';

// Validate the token
$validationResult = validateToken();
// Set content type header to JSON
header('Content-Type: application/json');
// Decode the JSON result
$decodedResult = json_decode($validationResult, true);

// Check if the token is valid
if (!$decodedResult["valid"]) {
    // Token is invalid, return 401 Unauthorized
    http_response_code(401);
    echo $validationResult; // Return the JSON-encoded error response
    exit();
}
// Token is valid and within the timeframe
// Define an array of messages
$messages = array(
    array(
        "date" => date("Y-m-d H:i:s"), // Current date and time
        "text" => "I am a robot."
    ),
    array(
        "date" => date("Y-m-d H:i:s", strtotime("-1 hour")), // One hour ago
        "text" => "Hello, world!"
    )
);

// Create an associative array to hold the messages array
$response = array("messages" => $messages);

// Set content type header to JSON
header('Content-Type: application/json');

// Output the JSON result
echo json_encode($response);
?>


