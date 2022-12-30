<x-mail::message>
# Complete your Lotus Under the Lights Reservation

Please follow the link below to verify your email address.
Once your email has been verified your reservation will be confirmed.

<x-mail::button :url="$signedVerifyURL">
Complete your Reservation
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
