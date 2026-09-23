@extends('layouts.main')

@section('title', 'Timer')

@section('content')
<main class="timer-page flex min-h-full flex-col" data-timer-state="idle">
    <header class="event-header">
        <p class="wordmark" aria-label="womENcourage 2026">wom<strong>EN</strong>courage™ 2026</p>
        <p class="event-meta">Sophia Antipolis · French Riviera<br>30 September – 2 October 2026</p>
    </header>

    <section class="timer-stage" aria-labelledby="timer-label">
        <p id="timer-label" class="stage-label">Session timer</p>
        <p id="time" class="large-timer" role="timer" aria-live="off">00:00</p>
        <p class="event-theme">Unmute Yourself, Grow Stronger Together</p>
    </section>

    <a class="timer-controls-link" href="{{ url('/controls') }}">Controls</a>
    <div class="wave-band" aria-hidden="true"></div>
</main>
@endsection
