@extends('lotus.layout')

@section('title', 'Verify Your Email')

@section('content')
    <section class="min-h-screen min-w-screen flex flex-col justify-center items-center bg-zinc-900 px-4 text-center">
        <h1 class="text-4xl md:text-7xl text-center text-rose-600 font-['Cinzel_Decorative'] mb-5">Reservation Cancelled</h1>
        <p class="text-white text-lg md:text-xl text-center">Your reservation has been cancelled.</p>
        <p class="text-white text-lg md:text-xl mb-4 text-center">Please visit the <a class="text-rose-200 underline" href="{{ route('lotus.index') }}">reservation page</a> to remake your reservation.</p>

        <a href="{{ route('lotus.index') }}" class="text-white bg-gradient-to-r from-red-500 to-rose-600 hover:to-red-500 hover:from-rose-600 transition-all inline-block px-9 py-3 rounded-md uppercase mb-3">Remake reservation</a>
    </section>
@endsection
