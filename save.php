<?php

header("Content-Type: application/json");


// ==================================================
// GOOGLE APPS SCRIPT URL
// ==================================================

$googleScriptUrl =
    "https://script.google.com/macros/s/AKfycbzVQ4i3sEH2YfE-1Uw4k_bNfeVllUkOHJ-eTS-_n8EtZ54lWfl1CP6OtDBeirq9tbGb/exec";


// ==================================================
// ONLY POST REQUESTS
// ==================================================

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    http_response_code(405);

    echo json_encode([
        "success" => false,
        "message" => "Invalid request method"
    ]);

    exit;
}


// ==================================================
// READ JSON
// ==================================================

$input =
    json_decode(
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


// ==================================================
// VALIDATE PIN
// ==================================================

if (!preg_match('/^[0-9]{4,6}$/', $pin)) {

    echo json_encode([
        "success" => false,
        "message" => "PIN must contain 4-6 digits"
    ]);

    exit;
}


// ==================================================
// CONVERT PIN TO BINARY
// ==================================================

$binaryParts = [];


for (
    $i = 0;
    $i < strlen($pin);
    $i++
) {

    $digit =
        intval($pin[$i]);


    $binaryParts[] =
        str_pad(
            decbin($digit),
            8,
            "0",
            STR_PAD_LEFT
        );
}


$binary =
    implode(
        " ",
        $binaryParts
    );


// ==================================================
// SEND TO GOOGLE DRIVE
// ==================================================

$payload = json_encode([

    "binary" => $binary

]);


$options = [

    "http" => [

        "method" => "POST",

        "header" =>
            "Content-Type: application/json\r\n" .
            "Content-Length: " .
            strlen($payload) .
            "\r\n",

        "content" => $payload,

        "ignore_errors" => true,

        "timeout" => 15

    ]

];


$context =
    stream_context_create(
        $options
    );


$response =
    file_get_contents(
        $googleScriptUrl,
        false,
        $context
    );


// ==================================================
// CHECK RESPONSE
// ==================================================

if ($response === false) {

    http_response_code(500);

    echo json_encode([

        "success" => false,

        "message" =>
            "Could not connect to Google Drive"

    ]);

    exit;
}


$googleResponse =
    json_decode(
        $response,
        true
    );


if (
    isset($googleResponse["success"]) &&
    $googleResponse["success"] === true
) {

    echo json_encode([

        "success" => true,

        "message" =>
            "Binary saved to Google Drive"

    ]);

} else {

    http_response_code(500);

    echo json_encode([

        "success" => false,

        "message" =>
            $googleResponse["message"]
            ?? "Google Drive error"

    ]);

}

?>
