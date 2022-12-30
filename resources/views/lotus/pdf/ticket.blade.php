<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>UAB VSA Lotus Under the Lights E-Ticket</title>

    <link href="{{ public_path('/css/app.css') }}" rel="stylesheet">
    <style>
        @font-face {
            font-family: 'Mukta';
            src: url({{ storage_path('fonts/Mukta-Bold.ttf') }}) format("truetype");
            font-weight: 800;
            font-style: normal;
        }

        body {
            font-family: 'Mukta', sans-serif;
        }

        .pdf-title {
            font-size: 2rem;
            letter-spacing: 1.1px;
            margin-bottom: 15px;
        }

        .ticket {
            width: 80%;
            margin: 0 auto;
            background: #eeeeee;
            border-radius: 5px;
            padding: 25px 20px;
        }

        .qr-code {
            margin-left: 150px;
            display: block;
            width: 250px;
        }

        .ticket-details {
            width: 100%;
        }

        .pdf-text-md {
            font-size: 1.1rem;
        }

        .ticket-details-row__info {
            width: 50%;
            padding: 6px 10px;
        }

        .ticket-details-row__info p:first-child {
            color: rgba(0, 0, 0, 0.50);
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 1.1px;
        }

        .ticket-details-row__info p:last-child {
            font-size: 1.1rem;
            letter-spacing: 1.1px;
        }

        .meta {
            margin-top: 180px;
            font-size: 0.8rem;
            color: rgba(0, 0, 0, 0.50);
            display: block;
            text-align: right;
        }
    </style>
</head>
<body>

<h1 class="pdf-title text-center font-bold font-[Mukta] uppercase tracking-wide">UAB VSA E-Ticket</h1>

<div class="ticket">
    <img class="qr-code mb-5" src="data:image/png;base64, {!! base64_encode($reservation->generateQrCode()) !!} ">
    <div class="ticket-details">
{{--        <h2 class="pdf-text-md text-center font-bold font-[Mukta] uppercase tracking-wide border-white mb-2">Ticket Summary</h2>--}}
        <table class="w-full">
            <tbody>
            <tr>
                <td class="ticket-details-row__info">
                    <p>Event</p>
                    <p>Lotus Under the Lights</p>
                </td>
                <td class="ticket-details-row__info">
                    <p>Location</p>
                    <p>Hill Student Center, 3rd Floor, Ballroom C</p>
                </td>
            </tr>
            <tr>
                <td class="ticket-details-row__info">
                    <p>Date</p>
                    <p>Saturday, February 18th, 2023</p>
                </td>
                <td class="ticket-details-row__info">
                    <p>Time</p>
                    <p>7:00 PM CST</p>
                </td>
            </tr>
            </tbody>
        </table>
        <br>
        <table class="w-full">
            <tbody>
            <tr>
                <td class="ticket-details-row__info">
                    <p>Name</p>
                    <p>{{ $reservation->name }}</p>
                </td>
                <td class="ticket-details-row__info">
                    <p>Type</p>
                    <p>{{ strtoupper($reservation->holder_type) }}</p>
                </td>
            </tr>
            <tr>
                <td class="ticket-details-row__info">
                    <p>Reservation #</p>
                    <p>{{ $reservation->id }}</p>
                </td>
                <td class="ticket-details-row__info">
                    <p>Tickets</p>
                    <p>{{ $reservation->tickets }}</p>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="legal">
    <p>Tickets are one time use. Please bring proper identification (Student ID)</p>
</div>
<br>
<div class="order-summary w-full">
    <h2 class="pdf-text-md text-center font-bold font-[Mukta] uppercase tracking-wide border-white mb-2">Order Summary</h2>
    <table class="w-full">
        <thead>
        <tr>
            <th>Item</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="text-left">Lotus Under the Lights Ticket ({{ strtoupper($reservation->holder_type) }})</td>
            <td class="text-left">{{ $reservation->tickets }}</td>
            <td class="text-left">${{ $reservation->isStudent() ? '0' : '7' }}</td>
            <td class="text-left">${{ $reservation->isStudent() ? 0 : $reservation->tickets * 7 }}</td>
        </tr>
        </tbody>
    </table>
</div>

<div class="meta">
    <p>Generated at {{ now()->format('Y-m-d H:i:s') }}</p>
</div>

</body>
</html>
