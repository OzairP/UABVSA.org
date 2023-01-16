@extends('lotus.layout')

@section('title', 'Reservation Expired')

@section('content')
    <section class="min-h-screen min-w-screen flex flex-col justify-center items-center bg-zinc-900 px-4 text-center x-pattern-2">
        <h1 class="text-4xl md:text-7xl text-center text-yellow-400 font-['Cinzel_Decorative'] mb-5">Reservation Expired</h1>
        <p class="text-white text-lg md:text-xl text-center">Your reservation has expired, please try again and verify your confirmation within 10 minutes.</p>
        <p class="text-white text-lg md:text-xl mb-4 text-center">Please visit the <a class="text-yellow-100 underline" href="{{ route('lotus.index') }}">reservation page</a> to remake your reservation.</p>

        <a href="{{ route('lotus.index') }}" class="text-black bg-yellow-500 hover:text-yellow-300 hover:bg-zinc-800 transition-all inline-block px-9 py-3 rounded-md uppercase mb-3">Remake reservation</a>
    </section>
@endsection
