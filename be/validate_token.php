<?php


/** 
 * Get header Authorization
 * */
function getAuthorizationHeader(){
    $headers = null;
    if (isset($_SERVER['Authorization'])) {
        $headers = trim($_SERVER["Authorization"]);
    }
    else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
        $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
    } elseif (function_exists('apache_request_headers')) {
        $requestHeaders = apache_request_headers();
        // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
        $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
        //print_r($requestHeaders);
        if (isset($requestHeaders['Authorization'])) {
            $headers = trim($requestHeaders['Authorization']);
        }
    }
    return $headers;
}

/**
 * get access token from header
 * */
function getBearerToken() {
    $headers = getAuthorizationHeader();
    // HEADER: Get the access token from the header
    if (!empty($headers)) {
        if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
            return $matches[1];
        }
    }
    return null;
}




function validateToken() {
    // Get the token from the Authorization header
    $token = getBearerToken();

    // Check if the token is present
    if (!$token) {
        return json_encode(array("valid" => false, "reason" => "Token is missing"));
    }

    // Decode the JWT token (without validation)
    $decodedToken = json_decode(base64_decode(str_replace('_', '/', str_replace('-', '+', explode('.', $token)[1]))), true);

    // Extracting claims
    $claims = $decodedToken;

    // Check if iat and exp claims exist
    if (isset($claims['iat']) && isset($claims['exp'])) {
        // Get the current UNIX timestamp
        $currentTimestamp = time();

        // Check if current time is between iat and exp
        if (
            $currentTimestamp >= $claims['iat'] && 
            $currentTimestamp <= $claims['exp'] &&
            $claims['iss'] == 'https://xxxxxx.okta.com/oauth2/default'
        ) {
            // Token is valid and within the timeframe
            return json_encode(array("valid" => true));
        } else {
            // Token is expired or invalid
            return json_encode(array("valid" => false, "reason" => "Expired token"));
        }
    } else {
        // iat and exp claims don't exist
        return json_encode(array("valid" => false, "reason" => "Invalid token"));
    }
}



?>
