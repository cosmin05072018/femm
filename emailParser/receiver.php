#!/usr/bin/php
<?php
require __DIR__ . '/../vendor/autoload.php';

$data = file_get_contents("php://stdin");

list($data, $body) = explode("\n\n", $data, 2);

$data = explode("\n", $data);
$patterns = array(
    'Return-Path',
    'X-Original-To',
    'Delivered-To',
    'Received',
    'To',
    'Message-Id',
    'Date',
    'From',
    'Subject',
);

// define a variable to hold parsed headers
$headers = array();

// loop through data
foreach ($data as $data_line) {

    // for each line, assume a match does not exist yet
    $pattern_match_exists = false;

    // check for lines that start with white space
    // NOTE: if a line starts with a white space, it signifies a continuation of the previous header
    if ((substr($data_line, 0, 1) == ' ' || substr($data_line, 0, 1) == "\t") && $last_match) {

        // append to last header
        $headers[$last_match][] = $data_line;
        continue;
    }

    // loop through patterns
    foreach ($patterns as $key => $pattern) {

        // create preg regex
        $preg_pattern = '/^' . $pattern . ': (.*)$/';

        // execute preg
        preg_match($preg_pattern, $data_line, $matches);

        // check if preg matches exist
        if (count($matches)) {

            $headers[$pattern][] = $matches[1];
            $pattern_match_exists = true;
            $last_match = $pattern;
        }
    }

    // check if a pattern did not match for this line
    if (!$pattern_match_exists) {
        $headers['UNMATCHED'][] = $data_line;
    }

    //   $client = new \GuzzleHttp\Client();
    //   $client->request('POST', 'https://femm.ro/api/email/receiver', [
    //     'body' => [
    //         'headers' => $headers,
    //         'email' => $body,
    //     ]
    // ]);
    $client->request('POST', 'https://femm.ro/api/email/receiver', [
        'form_params' => [
            'headers' => json_encode($headers), // Trimite ca string JSON
            'email' => $body,
        ]
    ]);
}
