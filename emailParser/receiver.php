#!/usr/local/bin/php -q
<?php

require __DIR__ . '/../vendor/autoload.php';

$data = file_get_contents("php://stdin");

if (!$data) {
    error_log("No data received on stdin");
    exit(1);
}

list($headersPart, $body) = explode("\n\n", $data, 2) + ["", ""];

if (empty($headersPart) || empty($body)) {
    error_log("Invalid email format: no headers or body found");
    exit(1);
}

$dataLines = explode("\n", $headersPart);
$patterns = [
    'Return-Path',
    'X-Original-To',
    'Delivered-To',
    'Received',
    'To',
    'Message-Id',
    'Date',
    'From',
    'Subject',
];

$headers = [];
$lastMatch = null;

foreach ($dataLines as $line) {
    if ((substr($line, 0, 1) == ' ' || substr($line, 0, 1) == "\t") && $lastMatch) {
        $headers[$lastMatch][] = trim($line);
        continue;
    }

    foreach ($patterns as $pattern) {
        if (preg_match('/^' . $pattern . ': (.*)$/', $line, $matches)) {
            $headers[$pattern][] = $matches[1];
            $lastMatch = $pattern;
            break;
        }
    }
}

$headers['UNMATCHED'] = $headers['UNMATCHED'] ?? [];

// Trimiterea cererii către API
try {
    $client = new \GuzzleHttp\Client();
    $client->request('POST', 'https://femm.ro/api/email/receiver', [
        'form_params' => [
            'headers' => json_encode($headers),
            'email' => $body,
        ]
    ]);


    echo "Email processed successfully, status code: " . $response->getStatusCode();
} catch (\Exception $e) {
    error_log("Error sending email to API: " . $e->getMessage());
}
