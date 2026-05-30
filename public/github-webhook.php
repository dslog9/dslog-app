<?php

$secret = 'e01159d5592024860969c3b0fef79bed7ea0245bef8760f142d951330052b803';

$logFile = '/var/www/storage/logs/dslog-webhook-debug.log';

file_put_contents($logFile, "\n=== " . date('Y-m-d H:i:s') . " ===\n", FILE_APPEND);
file_put_contents($logFile, "Method: " . ($_SERVER['REQUEST_METHOD'] ?? 'unknown') . "\n", FILE_APPEND);
file_put_contents($logFile, "Event: " . ($_SERVER['HTTP_X_GITHUB_EVENT'] ?? 'none') . "\n", FILE_APPEND);

$signature = $_SERVER['HTTP_X_HUB_SIGNATURE_256'] ?? '';
$payload = file_get_contents('php://input');

file_put_contents($logFile, "Signature present: " . ($signature ? 'yes' : 'no') . "\n", FILE_APPEND);
file_put_contents($logFile, "Payload length: " . strlen($payload) . "\n", FILE_APPEND);

if (!$signature || !$payload) {
    file_put_contents($logFile, "Result: bad request\n", FILE_APPEND);
    http_response_code(400);
    exit('Bad request');
}

$expected = 'sha256=' . hash_hmac('sha256', $payload, $secret);

if (!hash_equals($expected, $signature)) {
    file_put_contents($logFile, "Result: invalid signature\n", FILE_APPEND);
    http_response_code(403);
    exit('Invalid signature');
}

$event = $_SERVER['HTTP_X_GITHUB_EVENT'] ?? '';

if ($event === 'ping') {
    file_put_contents($logFile, "Result: pong\n", FILE_APPEND);
    http_response_code(200);
    exit('pong');
}

if ($event !== 'push') {
    file_put_contents($logFile, "Result: ignored event\n", FILE_APPEND);
    http_response_code(200);
    exit('ignored');
}

file_put_contents($logFile, "Result: triggering deploy\n", FILE_APPEND);

exec('/var/www/deploy.sh > /var/www/storage/logs/dslog-deploy.log 2>&1 &');

http_response_code(200);
echo 'deploy triggered';
