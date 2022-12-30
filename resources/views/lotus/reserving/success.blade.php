@extends('lotus.layout')

@section('title', 'Thank You')

@section('content')
    <section class="min-h-screen min-w-screen flex flex-col justify-center items-center bg-zinc-900 px-4 text-center">
        <h1 class="text-4xl md:text-7xl text-rose-600 font-['Cinzel_Decorative'] mb-5">Thank You</h1>
        <p class="text-white text-lg md:text-xl text-center">Your reservation details have been sent to <span class="text-rose-200">{{ $reservation->email }}</span>.</p>
        <p class="text-white text-lg md:text-xl mb-4 text-center">We are excited to see you then!</p>

        <a href="https://{{ explode('@', $reservation->email)[1] }}" class="text-white bg-gradient-to-r from-red-500 to-rose-600 hover:to-red-500 hover:from-rose-600 transition-all inline-block px-9 py-3 rounded-md uppercase mb-3" target="_blank">Go to {{ explode('@', $reservation->email)[1] }}</a>
    </section>
@endsection
