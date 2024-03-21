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

?>