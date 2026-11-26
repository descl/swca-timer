@extends('layouts.main')

@section('title', 'Display')

@section('content')
{{-- data-timer-state : idle | running | ending | finished (pilote par resources/js/app.js) --}}
<main id="display" data-timer-state="idle"
    class="display flex flex-col items-center justify-center h-screen overflow-hidden px-4 py-4">
    <img src="{{ Vite::asset('resources/images/Logo-SWCA-2025-Blanc.svg') }}" alt="Startup Weekend Côte d'Azur"
        class="display-logo mx-auto w-auto shrink-0">
    <p id="time" class="display-time large-timer font-semibold tracking-tight">
        --:--
    </p>
    <p class="display-finished">Temps écoulé</p>
    <p class="display-waiting">En attente du prochain timer</p>
</main>
@endsection
