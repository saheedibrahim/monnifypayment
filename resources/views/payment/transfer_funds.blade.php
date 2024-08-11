<?php

<form action="{{ route('transfer.funds') }}" method="POST">
    @csrf
    <input type="number" name="amount" placeholder="Enter amount" required>
    <input type="text" name="account_number" placeholder="Enter account number" required>
    <input type="text" name="bank_code" placeholder="Enter bank code" required>
    <input type="text" name="narration" placeholder="Enter narration" required>
    <button type="submit">Transfer Funds</button>
</form>
