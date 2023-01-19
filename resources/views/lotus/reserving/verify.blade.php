@extends('lotus.layout')

@section('title', 'Verify Your Email')

@section('content')
    <section class="min-h-screen min-w-screen flex flex-col justify-center items-center bg-zinc-900 px-4 text-center x-pattern-2">
        <h1 class="text-4xl md:text-7xl text-yellow-400 font-['Cinzel_Decorative'] mb-5">Verify Your Email</h1>
        <p class="text-white text-lg md:text-xl text-center">An email has been sent to <span class="text-yellow-100">{{ $reservation->email }}</span>.</p>
        <p class="text-white text-lg md:text-xl text-center">Follow the link to confirm your reservation.</p>

        @php
            $email = explode('@', $reservation->email)[1];
			$emailUrl = $email;
			if ($email === 'uab.edu') {
				$email = 'BlazerMail';
				$emailUrl = 'outlook.office.com/mail/';
            }
        @endphp
        <a href="https://{{ $emailUrl }}" class="text-black bg-yellow-500 hover:text-yellow-300 hover:bg-zinc-800 transition-all inline-block px-9 py-3 rounded-md uppercase my-3" target="_blank">Go to {{ $email }}</a>
        <p class="text-zinc-400 text-sm md:text-md font-black uppercase tracking-wide text-center">Your reservation will be held for 10 minutes<br>until your email is verified</p>
    </section>
@endsection
