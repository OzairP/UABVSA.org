@php /** @var App\Models\LotusReservation $reservation */ @endphp
    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>UAB VSA Lotus Under the Lights E-Ticket</title>

    <link href="{{ public_path('/css/app.css') }}" rel="stylesheet">
    <style>
        @font-face {
            font-family: 'Mukta';
            src: url({{ storage_path('fonts/Mukta-Bold.ttf') }}) format("truetype");
            font-weight: 800;
            font-style: normal;
        }

        @font-face {
            font-family: 'Cinzel Decorative';
            src: url({{ storage_path('fonts/CinzelDecorative-Bold.ttf') }}) format("truetype");
            font-weight: 800;
            font-style: normal;
        }

        body {
            font-family: 'Mukta', sans-serif;
            background: #1e1e24;
            position: relative;
        }

        .font-decorative {
            font-family: 'Cinzel Decorative', sans-serif;
        }

        .pdf-title {
            font-family: 'Cinzel Decorative', sans-serif;
            font-weight: 800;
            font-size: 2.5rem;
            letter-spacing: 1.1px;
            margin-bottom: 15px;
            color: rgb(250 204 21);
        }

        .ticket {
            background: rgb(39, 39, 48);
            border-radius: 5px;
            padding: 25px 20px;
        }

        .container {
            width: 80%;
            margin: 1rem auto;
        }

        .ticket--center {
            margin: 0 auto;
        }

        .qr-code {
            margin-left: 182.5px;
            display: block;
            width: 250px;
        }

        .ticket-details {
            width: 100%;
        }

        .pdf-text-md {
            font-size: 1.1rem;
            color: #fff;
        }

        .ticket-details-row__info {
            width: 50%;
            padding: 6px 10px;
        }

        .ticket-details-row__info p:first-child {
            color: rgba(255, 255, 255, 0.50);
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 1.1px;
        }

        .ticket-details-row__info p:last-child {
            font-size: 1.1rem;
            letter-spacing: 1.1px;
            color: rgba(255, 255, 255, 0.9);
        }

        .meta {
            position: absolute;
            bottom: 1rem;
            right: 1rem;
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.50);
            display: block;
            text-align: right;
        }

        .text-white {
            color: white;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .font-xl {
            font-size: 4rem;
        }

        .text-muted {
            color: rgba(255, 255, 255, 0.50);
        }

        .pdf-page {
            page-break-after: always;
            position: relative;
        }

        .pdf-page:last-child {
            page-break-after: avoid;
        }

        .mt-5 {
            margin-top: 5rem;
        }

        .pt-5 {
            padding-top: 5rem;
        }
    </style>
</head>
<body>
<div class="pdf-page">
    <h1 class="pdf-title text-center font-bold font-[Mukta] uppercase tracking-wide">Your Lotus E-Ticket</h1>

    <div class="container ticket">
        <div class="ticket-details">
            <h2 class="pdf-text-md text-center font-bold font-[Mukta] uppercase tracking-wide border-white mb-2">Reservation Details</h2>
            <table class="w-full">
                <tbody>
                <tr>
                    <td class="ticket-details-row__info">
                        <p>Name</p>
                        <p>{{ $reservation->name }}</p>
                    </td>
                    <td class="ticket-details-row__info">
                        <p>Type</p>
                        <p>{{ $reservation->holderTypeFormatted() }}</p>
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

    <div class="container ticket">
        <div class="ticket-details">
            <h2 class="pdf-text-md text-center font-bold font-[Mukta] uppercase tracking-wide border-white mb-2">Order Summary</h2>
            <table class="w-full text-white">
                <thead>
                <tr>
                    <th class="text-left">Item</th>
                    <th class="text-left">Unit Price</th>
                    <th class="text-left">Quantity</th>
                    <th class="text-right">Total</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="text-left">Lotus Under the Lights 3 Ticket</td>
                    <td class="text-left">${{ $reservation->isStudent() ? '0' : '7' }}</td>
                    <td class="text-left">{{ $reservation->tickets }}</td>
                    <td class="text-right">${{ $reservation->isStudent() ? 0 : $reservation->chargedPrice() }}</td>
                </tr>
                @unless($reservation->donationAmount() === 0)
                    <tr>
                        <td class="text-left">Lotus Donation</td>
                        <td class="text-left"></td>
                        <td class="text-left"></td>
                        <td class="text-right">${{ $reservation->donationAmount() }}</td>
                    </tr>
                @endunless
                <tr>
                    <td class="text-left">
                        <hr>
                    </td>
                    <td class="text-left">
                        <hr>
                    </td>
                    <td class="text-left">
                        <hr>
                    </td>
                    <td class="text-right">
                        <hr>
                    </td>
                </tr>
                <tr>
                    <td class="text-left">Subtotal</td>
                    <td class="text-left"></td>
                    <td class="text-left"></td>
                    <td class="text-right">${{ $reservation->subTotal() }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <h3 class="text-center font-decorative text-white font-xl text-muted">Please Find Your Tickets Below</h3>

    <div class="meta">
        <p>Generated at {{ now()->format('Y-m-d H:i:s') }}</p>
    </div>
</div>

@foreach($reservation->qrCodes(function (SimpleSoftwareIO\QrCode\Generator $qr) {
        	return $qr->backgroundColor(39, 39, 48);
        })
    as $qrCode)
    <div class="pdf-page pt-5">
        <div class="container ticket ticket--center mt-5">
            <div class="ticket-details">
                <h2 class="pdf-text-md text-center font-bold font-[Mukta] uppercase tracking-wide border-white mb-2">
                    Ticket
                    @if ($reservation->tickets > 1)
                        ({{ $loop->iteration }} of {{ $reservation->tickets }})
                    @endif
                </h2>
                <img class="qr-code mb-5" src="data:image/png;base64, {!! base64_encode($qrCode) !!} ">
                <table class="w-full">
                    <tbody>
                    <tr>
                        <td class="ticket-details-row__info">
                            <p>Event</p>
                            <p>Lotus Under the Lights 3: Where We Belong</p>
                        </td>
                        <td class="ticket-details-row__info">
                            <p>Location</p>
                            <p>Hill Student Center, 3rd Floor, Ballroom</p>
                        </td>
                    </tr>
                    <tr>
                        <td class="ticket-details-row__info">
                            <p>Date</p>
                            <p>Saturday, February 18th, 2023</p>
                        </td>
                        <td class="ticket-details-row__info">
                            <p>Address</p>
                            <p>1400 University Blvd, Birmingham, AL 35294</p>
                        </td>
                    </tr>
                    <tr>
                        <td class="ticket-details-row__info">
                            <p>Doors Open</p>
                            <p>5:00 PM CST</p>
                        </td>
                        <td class="ticket-details-row__info">
                            <p>Dress Attire</p>
                            <p>Formal Attire and Ao Dais</p>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <p class="container text-white text-muted text-center">
            For any questions, please contact Lotus Executive Directors, Angellina Luu (angelluu@uab.edu) and Sarah Tran (smvtran@uab.edu).
        </p>
        <div class="meta">
            <p>Generated at {{ now()->format('Y-m-d H:i:s') }}</p>
        </div>
    </div>
@endforeach

</body>
</html>
