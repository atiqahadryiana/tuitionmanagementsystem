<?php
$fee_record_id = $_GET['fee_record_id'];

// Example: Fetch the fee amount and student details to display on the payment page
// This can be linked to a real payment gateway API like Stripe, PayPal, etc.
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Gateway</title>
</head>
<body>
    <h2>Payment Page</h2>
    <p>Amount: RM 100.00</p>
    <p>Click below to complete your payment:</p>

    <!-- Example: Redirect to a real payment gateway -->
    <a href="https://www.paymentgateway.com/checkout?amount=100&fee_record_id=<?php echo $fee_record_id; ?>">Pay Now</a>
</body>
</html>
