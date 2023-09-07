<?php

use App\Http\Controllers\Profile\CommentController;
use App\Http\Controllers\Profile\TicketController;
use App\Http\Controllers\Profile\TypeController;
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


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [TicketController::class, 'index'])->name('dashboard');
    Route::get('/', [TicketController::class, 'index'])->name('ticket.index');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/admin/tickets/message/{ticket}', [CommentController::class, 'create'])->name('admin.tickets.message');

    Route::get('/tickets/data', [TicketController::class, 'getTicketsData'])->name('tickets.data');
    Route::post('/tickets/store/data', [TicketController::class, 'store'])->name('ticket.store');
    Route::get('/ticket/create', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/messages/{ticket}', [CommentController::class, 'index'])->name('messages.index');
    Route::get('/ticket/{ticket}', [TicketController::class, 'view'])->name('ticket.view');
    Route::post('/ticket/close/{ticket}', [TicketController::class, 'close'])->name('ticket.close');
    Route::delete('/ticket/destroy/{ticket}', [TicketController::class, 'destroy'])->name('ticket.destroy');

    Route::get('/admin/tickets/', [\App\Http\Controllers\Admin\TicketController::class, 'index'])->name('admin.ticket.index');

    Route::get('/type/create', [TypeController::class, 'create'])->name('type.create');
    Route::post('/type/store', [TypeController::class, 'store'])->name('type.store');
    Route::delete('/type/destroy/{type}', [TypeController::class, 'delete'])->name('type.destroy');
    Route::get('/type/edit/{type}', [TypeController::class, 'editForm'])->name('type.edit');
    Route::put('/type/update/{type}', [TypeController::class, 'edit'])->name('type.update');
    Route::get('/type/index', [TypeController::class, 'index'])->name('type.index');

});
Route::post('/ticket/reopen/{ticket}', [\App\Http\Controllers\Admin\TicketController::class, 'reopen'])->name('tickets.reopen');

require __DIR__.'/auth.php';
