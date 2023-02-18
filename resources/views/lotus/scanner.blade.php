@extends('layouts.main')

@section('title', 'Lotus Under the Lights')

@section('styles')
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700;900&family=Mukta:wght@300;400;700;900&display=swap" rel="stylesheet">
@endsection

@push('body-styles', 'h-screen w-screen overflow-hidden')

@section('content')
    <div class="w-screen h-screen m-0 bg-black">
        <div class="relative w-full h-full flex justify-center">
            <video class="absolute top-0 left-0 w-full h-full bg-black" id="scanner"></video>
            <div id="result-overlay-shadow" class="absolute z-10 top-0 left-0 w-full h-full bg-black opacity-0 transition-all duration-300 ease-[cubic-bezier(0.25,1,0.5,1)]"></div>
            <div id="result-overlay" class="absolute z-20 bg-white rounded-xl h-1/2 w-full max-w-6xl -bottom-1/2 -translate-y-full transform-none transition-all transform-gpu duration-300 ease-[cubic-bezier(0.25,1,0.5,1)]">
                <div class="p-4 relative flex flex-col h-full" x-reservation-target>
                    <div>
                        <button id="close-result-overlay" class="text-2xl font-bold float-right opacity-30">X</button>
                        <h1 class="text-4xl text-slate-900">Reservation #<span x-reservation-data="id"></span></h1>
                        <h1 class="text-lg font-bold uppercase tracking-widest text-slate-700">TICKET
                            <span x-reservation-data="ticket_number"></span> OF
                            <span x-reservation-data="tickets"></span></h1>
                        <hr />
                    </div>
                    <div class="mt-4 space-y-3 h-fit overflow-y-scroll flex-grow">
                        <div class="flex flex-row flex-wrap flex-grow">
                            <div class="flex-grow">
                                <h2 class="text-sm font-bold uppercase tracking-widest text-slate-700">Reservation Holder</h2>
                                <p id="result-code" class="text-xl font-bold" x-reservation-data="name"></p>
                            </div>
                            <div class="flex-grow">
                                <h2 class="text-sm font-bold uppercase tracking-widest text-slate-700">Type</h2>
                                <p id="result-code" class="text-xl font-bold" x-reservation-data="holder_type"></p>
                            </div>
                        </div>
                        <div class="flex flex-row flex-wrap flex-grow">
                            <div class="flex-grow">
                                <h2 class="text-sm font-bold uppercase tracking-widest text-slate-700">Ticket Confirmation</h2>
                                <div class="text-sm bg-green-600 text-white rounded px-2 py-1 tracking-widest uppercase font-black flex items-center w-fit space-x-2 px-4 pr-5" x-reservation-if="confirmed">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="ml-1 w-4 h-4 stroke-white">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                    </svg>
                                    <span>CONFIRMED</span>
                                </div>
                            </div>
                            <div class="flex-grow">
                                <h2 class="text-sm font-bold uppercase tracking-widest text-slate-700">Check In Status</h2>
                                <div class="text-sm bg-green-600 text-white rounded px-2 py-1 tracking-widest uppercase font-black flex items-center w-fit space-x-2 px-4 pr-5" x-reservation-if="checked_in_at">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="ml-1 w-4 h-4 stroke-white">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                    </svg>
                                    <span x-reservation-data="checked_in_time"></span>
                                </div>
                                <div class="text-sm bg-red-500 text-white rounded px-2 py-1 tracking-widest uppercase font-black flex items-center w-fit space-x-2 px-4 pr-5" x-reservation-not-if="checked_in_at">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 stroke-white">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    <span>NOT CHECKED IN</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-row flex-wrap">
                            <div class="flex flex-col flex-grow">
                                <h2 class="text-sm font-bold uppercase tracking-widest text-slate-700">Dietary Restrictions</h2>
                                <p id="result-format" class="text-xl font-bold" x-reservation-data="dietary">None</p>
                            </div>
                            <div class="flex flex-col flex-grow">
                                <h2 class="text-sm font-bold uppercase tracking-widest text-slate-700">Accommodations</h2>
                                <p id="result-format" class="text-xl font-bold" x-reservation-data="accommodations">None</p>
                            </div>
                        </div>
                        <div class="flex flex-row flex-wrap">
                            <div class="flex flex-col">
                                <h2 class="text-sm font-bold uppercase tracking-widest text-slate-700">Affiliation</h2>
                                <p id="result-format" class="text-xl font-bold" x-reservation-data="affiliation">None</p>
                            </div>
                        </div>
                    </div>
                    <div class="pt-2 w-full flex flex-row justify-center items-middle space-x-2 relative">
                        <div class="absolute left-0 -top-5 w-full h-5 bg-gradient-to-t from-white to-transparent"></div>
                        <button id="overlay-close" class="flex-grow py-2 bg-slate-600 text-white font-light uppercase text-xl text-center rounded tracking-widest">Close</button>
                        <button id="overlay-check-in" class="flex-grow py-2 bg-green-600 text-white font-light uppercase text-xl text-center rounded tracking-widest" x-reservation-if="check_in_eligible">Check-In</button>
                    </div>
                </div>
            </div>
        </div>
        @endsection

        @push('scripts')
            <script src="/js/lotus/scanner.js" type="text/javascript"></script>
    @endpush
