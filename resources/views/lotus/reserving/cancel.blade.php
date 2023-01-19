@extends('lotus.layout')

@section('title', 'Verify Your Email')

@section('content')
    <section class="min-h-screen min-w-screen flex flex-col justify-center items-center bg-zinc-900 px-4 text-center x-pattern-2">
        <h1 class="text-4xl md:text-7xl text-center text-yellow-400 font-['Cinzel_Decorative'] mb-5">Reservation Cancelled</h1>
        <p class="text-white text-lg md:text-xl text-center">Your reservation has been cancelled.</p>
        <p class="text-white text-lg md:text-xl mb-4 text-center">Please visit the <a class="text-yellow-100 underline" href="{{ route('lotus.index') }}">reservation page</a> to remake your reservation.</p>

        <a href="{{ route('lotus.index') }}" class="text-black bg-yellow-500 hover:text-yellow-300 hover:bg-zinc-800 transition-all inline-block px-9 py-3 rounded-md uppercase mt-3">Remake Reservation</a>
    </section>
@endsection
