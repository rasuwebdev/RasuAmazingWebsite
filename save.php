<?php

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);

    echo json_encode([
        "success" => false,
        "message" => "Invalid request"
    ]);

    exit;
}

$input = json_decode(
    file_get_contents("php://input"),
    true
);

if (!isset($input["pin"])) {
    echo json_encode([
        "success" => false,
        "message" => "PIN not received"
    ]);

    exit;
}

$pin = $input["pin"];

/*
 * Validate PIN
 */
if (!preg_match('/^[0-9]{4,6}$/', $pin)) {

    echo json_encode([
        "success" => false,
        "message" => "PIN must contain 4-6 digits"
    ]);

    exit;
}

/*
 * Convert every digit to 8-bit binary
 */
$binaryParts = [];

for ($i = 0; $i < strlen($pin); $i++) {

    $digit = intval($pin[$i]);

    $binaryParts[] = str_pad(
        decbin($digit),
        8,
        "0",
        STR_PAD_LEFT
    );
}

$binary = implode(" ", $binaryParts);

/*
 * Persistent disk location
 */
$dataDirectory = "/data";

$dataFile = $dataDirectory . "/pins.txt";

/*
 * Make sure directory exists
 */
if (!is_dir($dataDirectory)) {

    mkdir($dataDirectory, 0775, true);
}

/*
 * Save timestamp + binary
 *
 * Original PIN is NOT saved.
 */
$line =
    date("Y-m-d H:i:s") .
    " | " .
    $binary .
    PHP_EOL;

$result = file_put_contents(
    $dataFile,
    $line,
    FILE_APPEND | LOCK_EX
);

if ($result === false) {

    http_response_code(500);

    echo json_encode([
        "success" => false,
        "message" => "Could not save data"
    ]);

    exit;
}

echo json_encode([
    "success" => true,
    "message" => "Binary data saved"
]);

?>
