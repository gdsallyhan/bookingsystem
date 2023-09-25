<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt</title>
    <style>
        body {
            font-family: "Arial", sans-serif;
            margin: 0;
            padding: 0;
            background-color: #0b0a0a;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .receipt {
            width: 300px;
            padding: 20px;
            background-color: #fcfbff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.103);
            color: #0c0c0c;
        }
        h1 {
            font-size: 30px;
            margin-bottom: 20px;
        }
       
        .info {
            margin-bottom: 10px;
        }
        .back-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="receipt">
        <h1>Payment Receipt</h1>

       <div class="info">
            <strong>Booking ID:</strong> {{ $booking->booking_no }}
            
        </div>
        <div class="info">
            <strong>Customer ID:</strong> {{ $booking->customer_id }}
        </div>
        <div class="info">
            <strong>Bill Code:</strong> {{ $data['billcode'] }}
        </div>
        <div class="info">
            <strong>Order ID:</strong> {{ $data['order_id'] }}
        </div>
        <div class="info">
            <strong>Transaction ID:</strong> {{ $data['transaction_id'] }}
        </div>

        
        <div class="info">
            <strong>Amount: RM </strong> {{ $booking->amount }}
        </div>
 <div class="info">
            <strong>Status:</strong> 
            @if($data['status_id'] == 1)
                Successful transaction!
            @elseif($data['status_id'] == 2)
                Pending transaction!
            @elseif($data['status_id'] == 3)
                Unsuccessful transaction!
            @endif
        </div>
        <a href="{{ route('home') }}" class="back-button">Back to Home</a>
    </div>
    <script>
        setTimeout(function() {
            window.location.href = "{{ route('home') }}";
        }, 6000); // 5 seconds
    </script>
</body>
</html>
