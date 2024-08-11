<!DOCTYPE html>
<html>
<head>
    <title>Payment Success</title>
</head>
<body>
    <h1>Payment Successful</h1>
    <p>Transaction Reference: {{ $transaction['transactionReference'] }}</p>
    <p>Payment Status: {{ $transaction['paymentStatus'] }}</p>
    <p>Amount Paid: {{ $transaction['amountPaid'] }}</p>
</body>
</html>
