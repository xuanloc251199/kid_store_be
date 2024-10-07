<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh Toán Demo</title>
</head>
<body>
    <h1>Thanh Toán Giả Lập</h1>

    <form action="{{ route('payment.process') }}" method="POST">
        @csrf
        <label for="card_number">Số thẻ:</label>
        <input type="text" id="card_number" name="card_number" placeholder="1234 5678 9012 3456" required><br><br>

        <label for="expiry_date">Ngày hết hạn:</label>
        <input type="text" id="expiry_date" name="expiry_date" placeholder="MM/YY" required><br><br>

        <label for="cvv">CVV:</label>
        <input type="text" id="cvv" name="cvv" placeholder="123" required><br><br>

        <label for="amount">Số tiền:</label>
        <input type="number" id="amount" name="amount" placeholder="100000" required><br><br>

        <button type="submit">Thanh toán</button>
    </form>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif
</body>
</html>
