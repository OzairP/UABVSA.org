@extends('lotus.layout')

@section('title', 'Thank You for Donating')

@section('content')
    <section class="min-h-screen min-w-screen flex flex-col justify-center items-center bg-zinc-900 px-4 text-center x-pattern-2">
        <h1 class="text-4xl md:text-7xl text-yellow-400 font-['Cinzel_Decorative'] mb-5">Thank you for your<br>donation to VSA!</h1>
        <p class="text-white text-lg md:text-xl text-center mb-5">Your donation helps to make our memorable cultural events possible.<br>We greatly appreciate your support, and we look forward to seeing you at the show!</p>

        <a href="{{ route('home') }}" class="text-black bg-yellow-500 hover:text-yellow-300 hover:bg-zinc-800 transition-all inline-block px-9 py-3 rounded-md uppercase mt-3">Return Home</a>
    </section>
@endsection
