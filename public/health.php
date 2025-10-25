<?php
// Simple health check endpoint for Railway
// This doesn't depend on Laravel framework

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

http_response_code(200);

echo json_encode([
    'status' => 'OK',
    'timestamp' => date('Y-m-d\TH:i:s\Z'),
    'service' => 'PHP Flower Shop',
    'php_version' => PHP_VERSION,
    'server_time' => time()
]);
exit;
?>