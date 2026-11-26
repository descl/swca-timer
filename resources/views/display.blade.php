@extends('layouts.main')

@section('title', 'Display')

@section('content')
<main class="flex flex-col items-center justify-center h-screen overflow-hidden bg-black px-4 py-4">
    <img src="{{ Vite::asset('resources/images/Logo-SWCA-2025-Blanc.svg') }}" alt="Startup Weekend Côte d'Azur" class="mx-auto h-[14vh] max-w-[90vw] w-auto shrink-0">
    <p id="time" class="large-timer font-semibold tracking-tight text-balance text-white">
        -- : --
    </p>
</main>
@endsection