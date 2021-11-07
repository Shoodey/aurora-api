<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ChannelController;

Route::middleware(['auth:api'])->group(function () {
    Route::apiResource('channels', ChannelController::class);
});
