<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tickets\Ticket;
use App\Models\Tickets\Type;
use App\Services\Ticket\TicketService;
use Illuminate\Support\Facades\Auth;

final class TicketController extends Controller
{
    public function __construct(
        private TicketService $service
    ) {
        $this->middleware('can:manage-tickets');
    }

    public function index()
    {
        $user = Auth::user();
        $ticketTypes = Type::all();

        return view('tickets.index', compact('ticketTypes', 'user'));

    }

    public function reopen(Ticket $ticket)
    {
        try {
            $this->service->reopen(Auth::id(), $ticket->id);
        } catch (\DomainException $e) {

            return back()->with('error', $e->getMessage());
        }

        return back()->with('success');
    }
}
