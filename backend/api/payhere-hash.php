<?php

header("Content-Type: application/json");


// ===============================
// PAYHERE SANDBOX DETAILS
// ===============================

$merchant_id = "1238363";

$merchant_secret = "MzQ0ODg1MzkzMjE3NzU1Njg4OTkzMTU5ODQ1OTkwMTgwNTA0MzQ3";


// ===============================
// GET REQUEST
// ===============================

$input = json_decode(
    file_get_contents("php://input"),
    true
);


if (!$input) {

    echo json_encode([
        "success" => false,
        "message" => "Invalid request."
    ]);

    exit;
}


// ===============================
// DATA
// ===============================

$order_id = $input["order_id"] ?? "";

$amount = $input["amount"] ?? "";

$currency = $input["currency"] ?? "LKR";


if ($order_id === "" || $amount === "") {

    echo json_encode([
        "success" => false,
        "message" => "Missing payment information."
    ]);

    exit;
}


// ===============================
// FORMAT AMOUNT
// ===============================

$amount = number_format(
    (float)$amount,
    2,
    ".",
    ""
);


// ===============================
// GENERATE HASH
// ===============================

$hashed_secret = strtoupper(
    md5($merchant_secret)
);


$hash = strtoupper(
    md5(
        $merchant_id .
        $order_id .
        $amount .
        $currency .
        $hashed_secret
    )
);


// ===============================
// RESPONSE
// ===============================

echo json_encode([

    "success" => true,

    "merchant_id" => $merchant_id,

    "hash" => $hash,

    "notify_url" =>
        "http://localhost/Ceylon-Tea-House/backend/api/payhere-notify.php"

]);