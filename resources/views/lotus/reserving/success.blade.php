@extends('lotus.layout')

@section('title', 'Thank You')

@section('content')
    <section class="min-h-screen min-w-screen flex flex-col justify-center items-center bg-zinc-900 px-4 text-center">
        <h1 class="text-4xl md:text-7xl text-rose-600 font-['Cinzel_Decorative'] mb-5">Thank You</h1>
        <p class="text-white text-lg md:text-xl text-center">Your reservation details have been sent to <span class="text-rose-200">{{ $reservation->email }}</span>.</p>
        <p class="text-white text-lg md:text-xl mb-4 text-center">We are excited to see you then!</p>

        <a href="https://{{ explode('@', $reservation->email)[1] }}" class="text-white bg-gradient-to-r from-red-500 to-rose-600 hover:to-red-500 hover:from-rose-600 transition-all inline-block px-9 py-3 rounded-md uppercase mb-3" target="_blank">Go to {{ explode('@', $reservation->email)[1] }}</a>

        <div class="bg-red-100 text-red-700 px-6 py-4 rounded-lg text-black mt-9">
            <div class="flex flex-row mb-1">
                <div class="flex-shrink flex items-center mr-2 stroke-red-700">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 stroke-red-700">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 11.25v8.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 109.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1114.625 7.5H12m0 0V21m-8.625-9.75h18c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125h-18c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                    </svg>
                </div>
                <div class="flex-grow">
                    <p class="break-all text-xl text-left">Would you like to make a donation?</p>
                </div>
            </div>
            <p>Donations help us continue to running programs like these.</p>
            <div class="flex justify-end mt-5">
                <a href="{{ route('lotus.donate') }}" class="text-white bg-gradient-to-r from-red-500 to-rose-600 hover:to-red-500 hover:from-rose-600 transition-all inline-block px-5 py-1 rounded-md">Yes, I'd like to make a donation</a>
            </div>
        </div>
    </section>
@endsection
