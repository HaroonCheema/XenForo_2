<?php
// payment.php - Proxy handler for CoinPayments API and IPN

// Set default response header
header('Content-Type: application/json');

// Secret token for validating the proxy client (your XenForo site)
$expectedAuth = '66d4db93CdCb09ff7502eABa7f62566d0';
$headers = getallheaders();
$auth = $headers['X-Proxy-Auth'] ?? $headers['x-proxy-auth'] ?? '';
$HMAC = $headers['HMAC'] ?? '';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    // ========== [GET: Proxy API call to CoinPayments] ==========

    if ($auth !== $expectedAuth) {
        http_response_code(403);
        echo json_encode(['error' => 'Unauthorized']);
        exit;
    }

    // Validate parameters
    $publicKey = $_GET['key'] ?? '';
    $privateKey = $_GET['private_key'] ?? '';
    $cmd = $_GET['cmd'] ?? '';

    if (!$publicKey || !$privateKey || !$cmd) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing required parameters']);
        exit;
    }

    // Build parameters
    $params = $_GET;
    unset($params['private_key']); // Do not send private key in request params

    $params['version'] = 1;
    $params['format'] = 'json';
    $params['key'] = $publicKey;
    $params['cmd'] = $cmd;

    $query = http_build_query($params, '', '&');

    // Generate HMAC signature
    $hmac = hash_hmac('sha512', $query, $privateKey);

    // Make CoinPayments API call
    $ch = curl_init('https://www.coinpayments.net/api.php');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'HMAC: ' . $hmac
    ]);

    $response = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    if (!$response) {
        echo json_encode(['error' => 'cURL error', 'message' => $error]);
        exit;
    }

    echo $response;
    exit;
} elseif ($method === 'POST') {
    // ========== [POST: Handle IPN and forward to XenForo site] ==========

    // IPN callback URL on your XenForo site
    $callbackUrl = 'https://celebforum.to/payment_callback.php?_xfProvider=coinpayments';

    $rawPost = file_get_contents('php://input');
    $hmac = $_SERVER['HTTP_HMAC'] ?? '';

    // Forward the raw IPN data to XenForo
    $ch = curl_init($callbackUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $rawPost);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/x-www-form-urlencoded',
        'HMAC: ' . $hmac
    ]);

    $response = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    if ($response === false) {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to forward IPN', 'message' => $error]);
        exit;
    }

    // Return response from XenForo
    echo $response;
    exit;
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}
