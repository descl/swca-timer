<?php

namespace App\Http\Controllers;

use App\Http\Requests\StartTimerRequest;
use App\Models\Timer;

class TimerController extends Controller
{
    public function start(StartTimerRequest $request, int $timer)
    {
        $timer = Timer::find($timer);

        if (! $timer) {
            $timer = new Timer();
        }

        ['duration' => $duration] = $request->validated();

        $timer->end_at = time() + $duration;
        $timer->save();
    }

    public function stop(Timer $timer)
    {
        $timer->end_at = null;
        $timer->save();
    }

    public function status(Timer $timer)
    {
        return response()->json([
            'end_at' => $timer->end_at,
            'updated_at' => $timer->updated_at,
        ]);
    }
}
