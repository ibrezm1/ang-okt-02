<?php
require 'vendor/autoload.php';

use Firebase\JWT\JWK;
use Firebase\JWT\JWT;


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






/**
 * Fetch the JSON Web Key Set (JWKS) from the key endpoint with caching.
 *
 * @param string $keyEndpoint The URL of the key endpoint.
 * @param int $cacheDuration The duration (in seconds) to cache the JWKS.
 * @return array|false The JWKS array on success, false on failure.
 */
function fetchJwksWithCaching($keyEndpoint, $cacheDuration = 3600)
{
    // Cache file path
    $cacheFile = 'jwks_cache.json';

    // Check if cache file exists and is not expired
    if (file_exists($cacheFile) && time() - filemtime($cacheFile) < $cacheDuration) {
        // Read JWKS from cache file
        $jwks_json = file_get_contents($cacheFile);
    } else {
        // Fetch JWKS from the key endpoint
        $jwks_json = file_get_contents($keyEndpoint);

        // Save JWKS to cache file
        file_put_contents($cacheFile, $jwks_json);
    }

    // Decode JWKS JSON
    $jwks = json_decode($jwks_json, true);

    return $jwks ?: false;
}

/**
 * Validate a JWT token.
 *
 * @param string $token The JWT token to validate.
 * @param string $keyEndpoint The URL of the key endpoint.
 * @return array An associative array containing the validation result and additional details.
 */
function validateToken($token, $keyEndpoint)
{
    try {
        // Fetch JWKS with caching
        $jwks = fetchJwksWithCaching($keyEndpoint);

        if ($jwks === false) {
            throw new Exception("Failed to fetch JWKS.");
        }

        // Decode the JWT token using Firebase\JWT\JWT::decode
        $decoded = JWT::decode($token, JWK::parseKeySet($jwks));

        // Token is valid
        return array('valid' => true);
    } catch (Exception $e) {
        // Token is not valid
        return array('valid' => false, 'error' => $e->getMessage());
    }
}


?>
