<?php

require 'validate_token.php';
$token = getBearerToken() ?? '';
$keyEndpoint = 'https://dev-06315090.okta.com/oauth2/default/v1/keys';
// Validate the token

$result = validateToken($token, $keyEndpoint);
// Set content type header to JSON
header('Content-Type: application/json');

// Check if the token is valid
if (!$result["valid"]) {
    // Token is invalid, return 401 Unauthorized
    http_response_code(401);
    echo json_encode($result); // Return the JSON-encoded error response
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


