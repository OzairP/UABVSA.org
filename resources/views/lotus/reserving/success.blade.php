@extends('lotus.layout')

@section('title', 'Thank You')

@section('content')
    <section class="min-h-screen min-w-screen flex flex-col justify-center items-center bg-zinc-900 px-4 text-center x-pattern-2">
        <h1 class="text-4xl md:text-7xl text-yellow-400 font-['Cinzel_Decorative'] mb-5">Thank You</h1>
        <p class="text-white text-lg md:text-xl text-center">Your reservation details have been sent to <span class="text-yellow-200">{{ $reservation->email }}</span>.</p>
        <p class="text-white text-lg md:text-xl mb-4 text-center">We are excited to see you then!</p>

        <div class="flex flex-row space-x-4">
            <a href="https://{{ explode('@', $reservation->email)[1] }}" class="text-white bg-zinc-700 hover:bg-emerald-700 transition-all inline-block px-9 py-3 rounded-md uppercase mb-3" target="_blank">Go to {{ explode('@', $reservation->email)[1] }}</a>
            <a href="{{ $downloadLink }}" class="text-yellow-300 bg-emerald-700 hover:bg-emerald-700 transition-all inline-block px-9 py-3 rounded-md uppercase mb-3" target="_blank">Download my Ticket</a>
        </div>

        <div class="bg-yellow-300 text-black px-6 py-4 rounded-lg mt-9">
            <div class="flex flex-row mb-1">
                <div class="flex-shrink flex items-center mr-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 stroke-black">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 11.25v8.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 109.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1114.625 7.5H12m0 0V21m-8.625-9.75h18c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125h-18c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                    </svg>
                </div>
                <div class="flex-grow">
                    <p class="break-all text-xl text-left">Would you like to make a donation?</p>
                </div>
            </div>
            <p>Donations help us continue to run programs like these.</p>
            <div class="flex justify-end mt-5">
                <a href="{{ route('lotus.donate') }}" class="text-white bg-green-800 hover:bg-green-900 transition-all inline-block px-5 py-1 rounded-md">Yes, I'd like to make a donation
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 inline ml-0.5 -translate-y-0.5">
                        <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
                    </svg>
                </a>
            </div>
        </div>
    </section>
@endsection
