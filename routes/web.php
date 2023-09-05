<?php

use App\Http\Controllers\Profile\CommentController;
use App\Http\Controllers\Profile\TicketController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/', [TicketController::class, 'index'])->name('ticket.index');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get('/tickets/data', [TicketController::class, 'getTicketsData'])->name('tickets.data');
    Route::post('/tickets/store/data', [TicketController::class, 'store'])->name('tickets.store');
    Route::get('/ticket/create', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/messages/{ticket}', [CommentController::class, 'index'])->name('messages.index');
    Route::get('/ticket/{ticket}', [TicketController::class, 'view'])->name('ticket.view');
    Route::post('/ticket/close/{ticket}', [TicketController::class, 'close'])->name('ticket.close');
    Route::delete('/ticket/destroy/{ticket}', [TicketController::class, 'destroy'])->name('ticket.destroy');


});
Route::post('/admin/tickets/message/{ticket}', [\App\Http\Controllers\Admin\TicketController::class, 'message'])->name('admin.tickets.message');
Route::post('/ticket/reopen/{ticket}', [\App\Http\Controllers\Admin\TicketController::class, 'reopen'])->name('tickets.reopen');

require __DIR__.'/auth.php';
