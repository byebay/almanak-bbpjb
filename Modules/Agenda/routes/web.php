<?php

use Illuminate\Support\Facades\Route;
use Modules\Agenda\Http\Controllers\AgendaController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('agendas', AgendaController::class)->names('agenda');
});
