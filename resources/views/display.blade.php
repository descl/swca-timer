@extends('layouts.main')

@section('title', 'Display')

@section('content')
<main class="flex flex-col items-center justify-center min-h-full bg-white px-6 py-24 sm:py-32 lg:px-8">
    <img src="{{ Vite::asset('resources/images/Logo-SWCA-2025.png') }}" alt="SWCA Logo" class="mx-auto h-24 w-auto">
    <p id="time" class="large-timer font-semibold tracking-tight text-balance text-blue-900">
        -- : --
    </p>
</main>
@endsection