@extends('lotus.layout')

@section('title', 'Verify Your Email')

@section('content')
    <section class="min-h-screen min-w-screen flex flex-col justify-center items-center bg-zinc-900 px-4 text-center">
        <h1 class="text-4xl md:text-7xl text-rose-600 font-['Cinzel_Decorative'] mb-5">Verify Your Email</h1>
        <p class="text-white text-lg md:text-xl text-center">An email has been sent to <span class="text-rose-200">{{ $reservation->email }}</span>.</p>
        <p class="text-white text-lg md:text-xl mb-4 text-center">Follow the link to confirm your reservation.</p>

        <a href="https://{{ explode('@', $reservation->email)[1] }}" class="text-white bg-gradient-to-r from-red-500 to-rose-600 hover:to-red-500 hover:from-rose-600 transition-all inline-block px-9 py-3 rounded-md uppercase mb-3" target="_blank">Go to {{ explode('@', $reservation->email)[1] }}</a>
        <p class="text-zinc-400 text-sm md:text-md font-black uppercase tracking-wide text-center">Your reservation will be held for 10 minutes<br>until your email is verified</p>
    </section>
@endsection
