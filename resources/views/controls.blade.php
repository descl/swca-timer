@extends('layouts.main')

@section('title', 'Timer controls')

@section('content')
<main class="timer-page min-h-full" data-timer-state="idle">
    <header class="event-header">
        <p class="wordmark" aria-label="womENcourage 2026">wom<strong>EN</strong>courage™ 2026</p>
        <p class="event-meta">Sophia Antipolis · French Riviera<br>30 September – 2 October 2026</p>
    </header>

    <div class="control-shell">
        <h1 class="control-heading">Session timer</h1>
        <p class="control-intro">Set the duration and manage the timer shown on stage.</p>

        <div class="control-grid">
            <section class="preview-panel" aria-labelledby="preview-heading">
                <p id="preview-heading" class="stage-label">Live preview</p>
                <p id="time" class="preview-time" role="timer" aria-live="polite">00:00</p>
            </section>

            <section class="controls-panel" aria-labelledby="controls-heading">
                <h2 id="controls-heading" class="control-title">Duration</h2>

                <div class="preset-group" aria-label="Preset durations">
                    <button class="start-favorite preset-button" type="button" data-duration="60">1 min</button>
                    <button class="start-favorite preset-button" type="button" data-duration="120">2 min</button>
                    <button class="start-favorite preset-button" type="button" data-duration="180">3 min</button>
                </div>

                <div class="duration-field">
                    <label for="timeInput">Custom duration</label>
                    <div class="duration-input-wrap">
                        <input id="timeInput" type="number" inputmode="numeric" min="1" step="1" placeholder="300">
                        <span>seconds</span>
                    </div>
                </div>

                <div class="action-row">
                    <button id="startButton" class="action-button start-button" type="button">Start</button>
                    <button id="stopButton" class="action-button stop-button" type="button">Stop</button>
                </div>
            </section>
        </div>
    </div>

    <div class="wave-band" aria-hidden="true"></div>
</main>
@endsection
