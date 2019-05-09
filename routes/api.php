<?php

use Illuminate\Support\Facades\Route;
use Rochev\Laravel\SupportTickets\Http\Controllers\TicketController;

Route::apiResource('tickets', TicketController::class)->middleware('web');
