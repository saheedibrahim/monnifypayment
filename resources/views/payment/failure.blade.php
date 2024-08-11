<!DOCTYPE html>
<html>
<head>
    <title>Payment Failed</title>
</head>
<body>
    <h1>Payment Failed</h1>
    <p>Transaction Reference: {{ $transaction['transactionReference'] }}</p>
    <p>Payment Status: {{ $transaction['paymentStatus'] }}</p>
</body>
</html>
