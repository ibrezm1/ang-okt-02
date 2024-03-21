<?php
require 'vendor/autoload.php';

use Firebase\JWT\JWK;
use Firebase\JWT\JWT;

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

// Example usage:
//$token = 'eyJraWQiOiJjRnhrbFBlcGNYb1Ntb2pBVVhlMHdjRWNQSUtoV21URW52UTNFeklZcUNRIiwiYWxnIjoiUlMyNTYifQ.eyJ2ZXIiOjEsImp0aSI6IkFULmgxTWd2YUc2cnR2LU9uNExULWcwWm5BTHJ1U3JJLU1ka3VhWjBjUnlNZnciLCJpc3MiOiJodHRwczovL2Rldi0wNjMxNTA5MC5va3RhLmNvbS9vYXV0aDIvZGVmYXVsdCIsImF1ZCI6ImFwaTovL2RlZmF1bHQiLCJpYXQiOjE3MTEwNDIzMjksImV4cCI6MTcxMTA0NTkyOSwiY2lkIjoiMG9hZnd3MjVjOHFOVmUwOFE1ZDciLCJ1aWQiOiIwMHVmY2MyYjh5MkFpRk4xVTVkNyIsInNjcCI6WyJlbWFpbCIsInByb2ZpbGUiLCJvcGVuaWQiXSwiYXV0aF90aW1lIjoxNzExMDQyMjMyLCJzdWIiOiJib2phZmk1OTczQGVidXRob3IuY29tIn0.dJ9GNk6LipATd2Ky2I3ELr7o8yYBo2b8c67h-8ary7Jm4x8zw8MCiHBfHlvxAWkOISpE4ymEgIbFnl2dvzGHdEnMx-J183CVLDHTLNi2LVAybhFD0L53DXSx9vB5P1-nkOI4xzwBICfLFH_m1KTgcYxFxmr6AsguRSBq8dDwZPW-aBHxdwf56xVGjB-Wu1BevDYZ7GhD7GkzlEBdJy2U3wFfQdYnUHsaP1Xni4ZbfPvtas2cB66fAdRrw-VJ1xm-0MvfmnzzPfcua1h0brpk23poR21XuudjlppaAzkcB6KKBy78xPmjq07iNFWr7Xj7Uy2b70DNUKdsFsTZWy84Wg';
$token = 'eyJraWQiOiJjRnhrbFBlcGNYb1Ntb2pBVVhlMHdjRWNQSUtoV21URW52UTNFeklZcUNRIiwiYWxnIjoiUlMyNTYifQ.eyJ2ZXIiOjEsImp0aSI6IkFULjVCZ2t1THROZ3R0RFdLMURXaVFNNWh2Q0dMWFBWMl9vQ2hDalFldlJnZDgiLCJpc3MiOiJodHRwczovL2Rldi0wNjMxNTA5MC5va3RhLmNvbS9vYXV0aDIvZGVmYXVsdCIsImF1ZCI6ImFwaTovL2RlZmF1bHQiLCJpYXQiOjE3MTEwNTAyNTcsImV4cCI6MTcxMTA1Mzg1NywiY2lkIjoiMG9hZnd3MjVjOHFOVmUwOFE1ZDciLCJ1aWQiOiIwMHVmY2MyYjh5MkFpRk4xVTVkNyIsInNjcCI6WyJvcGVuaWQiLCJlbWFpbCIsInByb2ZpbGUiXSwiYXV0aF90aW1lIjoxNzExMDUwMjU1LCJzdWIiOiJib2phZmk1OTczQGVidXRob3IuY29tIn0.WQ4nqQdtMCZlLdeAKjGqxcUGWbfzcCNb6LaODnaz7auVWQOl1-vW_GNDBalz4Dhd0E_yXLtUEr_dwRd2DK9F6TXvRlatDUDmy1kuKf6V7vxXIDGqwmGHgHNMl-QFDU1oGL5jrMftLzmBCpbRWiWLXrZnrCmcY0-NTUX5vQfBwtFnQ6s74RCLbonX-GX734sLoMwMOB76uUBSnYVEuDKHC4PIUBeKAYn2HftiuA0PqbM857ktjUP_Wk2QLRHbnFlhxDNpm_XtTNDBcnn3FcLgYL-mubjZr45YsPItPZM-P3PKVQcglw3vRFGIbEkQt2pTlP2OpX3QcEa0Hmz1TH1a0w';

$keyEndpoint = 'https://dev-06315090.okta.com/oauth2/default/v1/keys';

$result = validateToken($token, $keyEndpoint);
echo json_encode($result);
echo json_encode($result['valid']) . "\n";
?>
