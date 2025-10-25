<?php
$url = "http://localhost:8000/admin/products";
$context = stream_context_create([
    'http' => [
        'timeout' => 5,
        'ignore_errors' => true
    ]
]);

$response = file_get_contents($url, false, $context);
$headers = $http_response_header ?? [];

echo "=== Testing Admin Products Page ===\n";
echo "URL: $url\n";
echo "Status: " . (isset($headers[0]) ? $headers[0] : "No response") . "\n";

if ($response !== false) {
    echo "Response Length: " . strlen($response) . " bytes\n";
    if (strpos($response, 'Products Management') !== false) {
        echo "✅ Page loaded successfully - contains expected content\n";
    } elseif (strpos($response, 'error') !== false || strpos($response, 'Exception') !== false) {
        echo "❌ Error detected in response\n";
        // Show first 500 chars of error
        echo "Error preview:\n" . substr($response, 0, 500) . "\n";
    } else {
        echo "⚠️ Page loaded but content unclear\n";
    }
} else {
    echo "❌ Failed to load page\n";
}
?>