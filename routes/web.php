<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('display');
});

Route::get('/controls', function () {
    return view('controls');
});
