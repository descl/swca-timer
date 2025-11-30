@extends('layouts.main')

@section('title', 'Display')

@section('content')
<main class="flex flex-col items-center min-h-full bg-white px-6 py-24 sm:py-32 lg:px-8">
    <img src="{{ Vite::asset('resources/images/Logo-SWCA-2025.png') }}" alt="SWCA Logo" class="mx-auto h-12 w-auto">
    <section class="mt-10">
        <h2 class="mt-10 text-2xl font-bold text-blue-900 text-center">Preview</h2>
        <p id="time" class="text-center font-semibold tracking-tight text-balance text-blue-900 text-8xl">
            -- : --
        </p>
    </section>
    <section class="mt-10">
        <h2 class="mt-10 text-2xl font-bold text-blue-900 text-center">Controls</h2>
        <div class="mt-6 flex gap-4 justify-center">
            <button class="start-favorite px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-700 grow-1"
                data-duration="300">5 Minutes</button>
            <button class="start-favorite px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-700 grow-1"
                data-duration="240">4 Minutes</button>
            <button class="start-favorite px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-700 grow-1"
                data-duration="60">1 Minute</button>
        </div>
        <div class="mt-4 flex gap-4 justify-end">
            <input id="timeInput" type="text" placeholder="Secondes" class="px-4 py-2 border rounded w-48 text-center">
            <button id="startButton"
                class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 grow-1">Start</button>
        </div>
        <div class="mt-4 flex gap-4 justify-end border-t pt-4">
            <button id="stopButton"
                class="px-4 py-2 bg-red-700 text-white rounded hover:bg-red-800 grow-1">Stop</button>
        </div>
    </section>
</main>
@endsection