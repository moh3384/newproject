<?php
header("Content-Type: application/json");
require "db.php";

$data = json_decode(file_get_contents("php://input"), true);

if(!$data){
    echo json_encode(["status"=>"error"]);
    exit;
}

$name = $conn->real_escape_string($data['name']);
$phone = $conn->real_escape_string($data['phone']);
$email = $conn->real_escape_string($data['email']);
$address = $conn->real_escape_string($data['address']);
$total_quantity = intval($data['total_quantity']);
$total_price = floatval($data['total_price']);
$order_details = $conn->real_escape_string($data['order_details']);

$sql = "INSERT INTO orders 
(customer_name, customer_phone, customer_email, customer_address, total_quantity, total_price, order_details)
VALUES
('$name','$phone','$email','$address','$total_quantity','$total_price','$order_details')";

if($conn->query($sql)){

    $storePhone = "966501871284";
    $message = urlencode($data['whatsapp_message']);
    $url = "https://wa.me/$storePhone?text=$message";

    echo json_encode([
        "status"=>"success",
        "url"=>$url
    ]);
} else {
    echo json_encode(["status"=>"error"]);
}
?>