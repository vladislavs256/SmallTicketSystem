<?php

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
    Route::get('/tickets/data', [TicketController::class, 'getTicketsData'])->name('tickets.data');
    Route::post('/messages/{ticket}', [\App\Http\Controllers\Profile\CommentController::class, 'index'])->name('messages.index');
    Route::get('/ticket/{ticket}', [TicketController::class, 'view'])->name('ticket.view');
    Route::get('/ticket/close/{ticket}', [TicketController::class, 'close'])->name('ticket.delete');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::post('/admin/tickets/message/{ticket}', [\App\Http\Controllers\Admin\TicketController::class, 'message'])->name('admin.tickets.message');

require __DIR__.'/auth.php';
