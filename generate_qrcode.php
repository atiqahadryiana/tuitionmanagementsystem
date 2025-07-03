<?php
include('phpqrcode/qrlib.php');  // Include the PHP QR Code library

$fee_record_id = $_GET['fee_record_id'];

// Create a payment URL (this can be a payment page URL or a URL for an integrated payment gateway)
$payment_url = "https://www.examplepaymentgateway.com/pay?fee_record_id=" . $fee_record_id;

// Generate the QR Code
QRcode::png($payment_url);  // This will output the QR code image directly
?>
