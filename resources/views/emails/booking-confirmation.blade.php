<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
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
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            padding: 40px 30px;
            text-align: center;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }
        .email-header h1 {
            color: #ffd700;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
            letter-spacing: -0.5px;
        }
        .email-header p {
            color: #ffffff;
            font-size: 16px;
            opacity: 0.9;
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
        .booking-details {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 25px;
            margin: 30px 0;
            border-left: 4px solid #ffd700;
        }
        .booking-details h2 {
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
        .fleet-item {
            background: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 15px;
        }
        .fleet-item h3 {
            color: #1a1a1a;
            font-size: 18px;
            margin-bottom: 10px;
            font-weight: 700;
        }
        .fleet-item p {
            color: #666;
            font-size: 14px;
            margin: 5px 0;
        }
        .price-highlight {
            color: #ffd700;
            font-size: 24px;
            font-weight: 700;
            margin-top: 10px;
        }
        .total-section {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            border-radius: 8px;
            padding: 25px;
            margin-top: 30px;
            text-align: center;
        }
        .total-section .label {
            color: #ffffff;
            font-size: 16px;
            opacity: 0.9;
            margin-bottom: 10px;
        }
        .total-section .amount {
            color: #ffd700;
            font-size: 36px;
            font-weight: 700;
        }
        .info-box {
            background: #fff3cd;
            border: 1px solid #ffd700;
            border-radius: 8px;
            padding: 20px;
            margin: 30px 0;
        }
        .info-box p {
            color: #856404;
            font-size: 14px;
            line-height: 1.6;
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
            <h1>Nuhi Great Travels</h1>
            <p>{{ $isAdmin ? 'New Booking Received' : 'Booking Confirmation' }}</p>
        </div>

        <div class="email-body">
            <div class="greeting">
                {{ $isAdmin ? 'Hello Admin,' : 'Hello ' . $booking->user->name . ',' }}
            </div>

            <div class="message">
                @if($isAdmin)
                    <p>A new booking has been received and requires your attention.</p>
                @else
                    <p>Thank you for choosing Nuhi Great Travels! Your booking has been confirmed and we're excited to serve you.</p>
                @endif
            </div>

            <div class="booking-details">
                <h2>Booking Details</h2>
                
                <div class="detail-row">
                    <span class="detail-label">Booking ID:</span>
                    <span class="detail-value"><strong>#{{ $booking->id }}</strong></span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Pickup Date & Time:</span>
                    <span class="detail-value">{{ \Carbon\Carbon::parse($booking->pickup_datetime)->format('F d, Y \a\t g:i A') }}</span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Dropoff Date & Time:</span>
                    <span class="detail-value">{{ \Carbon\Carbon::parse($booking->dropoff_datetime)->format('F d, Y \a\t g:i A') }}</span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Pickup Location:</span>
                    <span class="detail-value">{{ $booking->pickup_location }}</span>
                </div>

                @if($booking->dropoff_location && $booking->dropoff_location !== $booking->pickup_location)
                <div class="detail-row">
                    <span class="detail-label">Dropoff Location:</span>
                    <span class="detail-value">{{ $booking->dropoff_location }}</span>
                </div>
                @endif

                <div class="detail-row">
                    <span class="detail-label">Customer Name:</span>
                    <span class="detail-value">{{ $booking->user->name }}</span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Email:</span>
                    <span class="detail-value">{{ $booking->user->email }}</span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Phone:</span>
                    <span class="detail-value">{{ $booking->user->phone ?? 'N/A' }}</span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Payment Preference:</span>
                    <span class="detail-value">
                        <strong>{{ $booking->payment_preference === 'pay_now' ? 'Pay Now' : 'Pay Later' }}</strong>
                    </span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Status:</span>
                    <span class="detail-value">
                        <strong style="text-transform: capitalize;">{{ $booking->status }}</strong>
                    </span>
                </div>
            </div>

            @if(count($fleets) > 0)
            <div class="booking-details">
                <h2>Booked Vehicles</h2>
                @foreach($fleets as $fleet)
                <div class="fleet-item">
                    <h3>{{ $fleet->name }}</h3>
                    @if($fleet->car)
                    <p><strong>Category:</strong> {{ $fleet->car->make }}</p>
                    @endif
                    @if($fleet->seats)
                    <p><strong>Seats:</strong> {{ $fleet->seats }}</p>
                    @endif
                    @if($fleet->transmission)
                    <p><strong>Transmission:</strong> {{ $fleet->transmission }}</p>
                    @endif
                    <p class="price-highlight">KES {{ number_format($fleet->price_per_day, 2) }} / day</p>
                </div>
                @endforeach
            </div>
            @endif

            <div class="total-section">
                <div class="label">Total Amount</div>
                <div class="amount">KES {{ number_format($booking->total_price, 2) }}</div>
            </div>

            @if(!$isAdmin)
            <div class="info-box">
                <p><strong>What's Next?</strong></p>
                <p>
                    @if($booking->payment_preference === 'pay_now')
                        We'll send you a payment link shortly. Once payment is confirmed, your booking will be finalized.
                    @else
                        You can pay when you pick up the vehicle. Our team will contact you soon to confirm the details.
                    @endif
                </p>
            </div>
            @endif

            @if($booking->notes)
            <div class="info-box">
                <p><strong>Special Notes:</strong></p>
                <p>{{ $booking->notes }}</p>
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

