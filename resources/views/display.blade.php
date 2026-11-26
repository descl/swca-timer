@extends('layouts.main')

@section('title', 'Display')

@section('content')
<main class="flex flex-col items-center justify-center h-screen overflow-hidden bg-white px-4 py-4">
    <img src="{{ Vite::asset('resources/images/Logo-SWCA-2025.png') }}" alt="SWCA Logo" class="mx-auto h-[10vh] w-auto shrink-0">
    <p id="time" class="large-timer font-semibold tracking-tight text-balance text-blue-900">
        -- : --
    </p>
</main>
@endsection