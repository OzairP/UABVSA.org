@extends('lotus.layout')

@section('title', 'Reservation Pending')

@section('content')
    <section class="min-h-screen min-w-screen flex flex-col justify-center items-center bg-zinc-900 px-4 text-center x-pattern-2">
        <h1 class="text-4xl md:text-7xl text-center text-yellow-400 font-['Cinzel_Decorative'] mb-5">Reservation Pending</h1>
        <p class="text-white text-lg md:text-xl text-center">Thank you for reserving a ticket for <span class="text-yellow-200">Lotus Under the Lights 3: Where We Belong</span>.</p>
        <p class="text-white text-lg md:text-xl text-center">Your reservation is pending confirmation. Once our team confirms your reservation you will receive an email with you ticket in your BlazerMail.</p>
        <p class="text-white text-lg md:text-xl text-center">For any questions, please contact Lotus Executive Directors, Angellina Luu (<a href="mailto:angellu@uab.edu" class="text-yellow-400 underline">angelluu@uab.edu</a>) and Sarah Tran (<a href="mailto:smvtran@uab.edu" class="text-yellow-400 underline">smvtran@uab.edu</a>).</p>
    </section>
@endsection
