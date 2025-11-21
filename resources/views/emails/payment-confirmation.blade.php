<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Confirmation</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
        }
        .email-header {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            padding: 40px 30px;
            text-align: center;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }
        .email-header h1 {
            color: #ffffff;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
            letter-spacing: -0.5px;
        }
        .email-header p {
            color: #ffffff;
            font-size: 16px;
            opacity: 0.95;
        }
        .success-icon {
            width: 80px;
            height: 80px;
            background: #ffffff;
            border-radius: 50%;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            color: #28a745;
        }
        .email-body {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 18px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 20px;
        }
        .message {
            font-size: 16px;
            color: #555;
            margin-bottom: 30px;
            line-height: 1.8;
        }
        .success-badge {
            background: #d4edda;
            border: 2px solid #28a745;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            margin: 30px 0;
        }
        .success-badge p {
            color: #155724;
            font-size: 16px;
            font-weight: 600;
            margin: 0;
        }
        .payment-details {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 25px;
            margin: 30px 0;
            border-left: 4px solid #28a745;
        }
        .payment-details h2 {
            color: #1a1a1a;
            font-size: 20px;
            margin-bottom: 20px;
            font-weight: 700;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #e0e0e0;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .detail-label {
            font-weight: 600;
            color: #666;
            font-size: 14px;
        }
        .detail-value {
            color: #1a1a1a;
            font-size: 14px;
            text-align: right;
        }
        .amount-section {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border-radius: 8px;
            padding: 30px;
            margin-top: 30px;
            text-align: center;
        }
        .amount-section .label {
            color: #ffffff;
            font-size: 16px;
            opacity: 0.95;
            margin-bottom: 10px;
        }
        .amount-section .amount {
            color: #ffffff;
            font-size: 42px;
            font-weight: 700;
        }
        .booking-info {
            background: #e7f3ff;
            border: 1px solid #0066cc;
            border-radius: 8px;
            padding: 20px;
            margin: 30px 0;
        }
        .booking-info h3 {
            color: #004085;
            font-size: 16px;
            margin-bottom: 10px;
            font-weight: 700;
        }
        .booking-info p {
            color: #004085;
            font-size: 14px;
            margin: 5px 0;
        }
        .info-box {
            background: #fff3cd;
            border: 1px solid #ffc107;
            border-radius: 8px;
            padding: 20px;
            margin: 30px 0;
        }
        .info-box p {
            color: #856404;
            font-size: 14px;
            line-height: 1.6;
            margin: 5px 0;
        }
        .footer {
            background: #1a1a1a;
            padding: 30px;
            text-align: center;
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
        }
        .footer p {
            color: #ffffff;
            font-size: 14px;
            opacity: 0.8;
            margin: 5px 0;
        }
        .footer a {
            color: #ffd700;
            text-decoration: none;
        }
        @media only screen and (max-width: 600px) {
            .email-body {
                padding: 30px 20px;
            }
            .detail-row {
                flex-direction: column;
            }
            .detail-value {
                text-align: left;
                margin-top: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <div class="success-icon">✓</div>
            <h1>Payment Confirmed</h1>
            <p>{{ $isAdmin ? 'Payment Received' : 'Thank You for Your Payment' }}</p>
        </div>

        <div class="email-body">
            <div class="greeting">
                {{ $isAdmin ? 'Hello Admin,' : 'Hello ' . $invoice->full_name . ',' }}
            </div>

            <div class="message">
                @if($isAdmin)
                    <p>A payment has been successfully received for the following invoice.</p>
                @else
                    <p>We're pleased to confirm that your payment has been successfully processed. Your booking is now confirmed!</p>
                @endif
            </div>

            <div class="success-badge">
                <p>✓ Payment Successful</p>
            </div>

            <div class="payment-details">
                <h2>Payment Details</h2>
                
                <div class="detail-row">
                    <span class="detail-label">Invoice Number:</span>
                    <span class="detail-value"><strong>#{{ $invoice->invoice_number }}</strong></span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Payment Date:</span>
                    <span class="detail-value">{{ $invoice->payment_date ? \Carbon\Carbon::parse($invoice->payment_date)->format('F d, Y \a\t g:i A') : 'N/A' }}</span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Payment Reference:</span>
                    <span class="detail-value">{{ $invoice->payment_reference ?? 'N/A' }}</span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Customer Name:</span>
                    <span class="detail-value">{{ $invoice->full_name }}</span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Email:</span>
                    <span class="detail-value">{{ $invoice->email }}</span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Phone:</span>
                    <span class="detail-value">{{ $invoice->mpesa_number ?? 'N/A' }}</span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Status:</span>
                    <span class="detail-value">
                        <strong style="color: #28a745; text-transform: capitalize;">{{ $invoice->status }}</strong>
                    </span>
                </div>
            </div>

            @if($booking)
            <div class="booking-info">
                <h3>Related Booking Information</h3>
                <p><strong>Booking ID:</strong> #{{ $booking->id }}</p>
                <p><strong>Pickup Date:</strong> {{ \Carbon\Carbon::parse($booking->pickup_datetime)->format('F d, Y \a\t g:i A') }}</p>
                <p><strong>Dropoff Date:</strong> {{ \Carbon\Carbon::parse($booking->dropoff_datetime)->format('F d, Y \a\t g:i A') }}</p>
                <p><strong>Pickup Location:</strong> {{ $booking->pickup_location }}</p>
            </div>
            @endif

            <div class="amount-section">
                <div class="label">Amount Paid</div>
                <div class="amount">KES {{ number_format($invoice->total_price, 2) }}</div>
            </div>

            @if(!$isAdmin)
            <div class="info-box">
                <p><strong>What's Next?</strong></p>
                <p>Your booking is now confirmed and our team will contact you shortly to finalize the details. We look forward to serving you!</p>
            </div>
            @endif
        </div>

        <div class="footer">
            <p><strong>Nuhi Great Travels</strong></p>
            <p>Your trusted travel partner</p>
            <p>Email: bookings@nuhigreattravels.com</p>
            <p>Website: <a href="https://www.nuhiluxurytravel.com">www.nuhiluxurytravel.com</a></p>
        </div>
    </div>
</body>
</html>

