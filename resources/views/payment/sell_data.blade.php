<?php

<form action="{{ route('sell.data') }}" method="POST">
    @csrf
    <input type="number" name="amount" placeholder="Enter amount" required>
    <input type="text" name="phone_number" placeholder="Enter phone number" required>
    <input type="text" name="network_code" placeholder="Enter network code" required>
    <button type="submit">Buy Data</button>
</form>
