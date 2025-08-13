<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Transaction Statement - Fee24MFB</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            margin: 40px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo {
            height: 60px;
            margin-bottom: 10px;
        }

        .company-name {
            font-size: 22px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .statement-title {
            font-size: 16px;
            font-weight: bold;
            text-decoration: underline;
        }

        .customer-info {
            margin-top: 20px;
            font-size: 13px;
        }

        .customer-info p {
            margin: 4px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        th {
            background-color: #2c3e50;
            color: white;
            padding: 8px;
            font-weight: bold;
            text-align: center;
        }

        td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
        }

        .total {
            margin-top: 20px;
            text-align: right;
            font-size: 14px;
            font-weight: bold;
        }

        .footer {
            margin-top: 50px;
            font-size: 12px;
            text-align: center;
            color: #888;
        }

        .footer a {
            color: #3498db;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="header">
        <img src="{{ public_path('assets/images/logo/logo.png') }}" class="logo" alt="Fee23MFB Logo">
        <div class="company-name">Fee24 Microfinance Bank</div>
        <div class="statement-title">Transaction Statement</div>
    </div>

    <div class="customer-info">
        <p><strong>Customer Name:</strong> {{ $user->first_name }} {{ $user->last_name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Address:</strong> {{ $user->address ?? 'No address found' }}</p>
        <p><strong>Date Generated:</strong> {{ \Carbon\Carbon::now()->format('M d, Y h:i A') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Amount (₦)</th>
                <th>Description</th>
                <th>Type</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $txn)
                <tr>
                    <td>{{ $txn->id }}</td>
                    <td>{{ number_format($txn->amount, 2) }}</td>
                    <td>{{ $txn->description }}</td>
                    <td>{{ ucfirst($txn->type) }}</td>
                    <td>{{ ucfirst($txn->status) }}</td>
                    <td>{{ $txn->created_at->format('M d, Y g:i A') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        Total Balance: ₦{{ number_format($totalAmount, 2) }}
    </div>

    <div class="footer">
        <p>Fee23MFB • <a href="https://fee24mfb.com">www.fee24mfb.com</a> • Support: <a href="mailto:support@fee24mfb.com">support@fee24mfb.com</a></p>
    </div>

</body>
</html>
