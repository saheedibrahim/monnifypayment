<form action="{{ route('pay.utility.bills') }}" method="POST">
    @csrf
    <input type="number" name="amount" placeholder="Enter amount" required>
    <input type="text" name="customer_account_number" placeholder="Enter customer account number" required>
    <input type="text" name="provider_code" placeholder="Enter provider code" required>
    <input type="text" name="service_code" placeholder="Enter service code" required>
    <button type="submit">Pay Utility Bills</button>
</form>
