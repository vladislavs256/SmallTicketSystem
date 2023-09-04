<?php

declare(strict_types=1);

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\Tickets\Ticket;
use App\Models\Tickets\Type;
use App\Services\Ticket\TicketService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

final class TicketController extends Controller
{
    public function __construct(
        private TicketService $service
    ) {
    }

    public function index()
    {
        $tickets = Ticket::forUser(Auth::user())->orderBy('id')->paginate(20);
        $ticketTypes = Type::all();

        return view('tickets.index', compact('tickets', 'ticketTypes'));
    }

    public function view(Ticket $ticket)
    {
        return view('tickets.view', compact('ticket'));
    }

    public function getTicketsData(Request $request)
    {
        $responseData = $this->service->getTicketsData($request);

        return response()->json($responseData);
    }

    public function show(Ticket $ticket)
    {
        return view('tickets.show', compact('ticket'));
    }

    public function close(Ticket $ticket)
    {
        $this->checkAccess($ticket);
        try {
            $this->service->close(Auth::id(), $ticket->id);
        } catch (\DomainException $e) {
            return back()->with('error', $e->getMessage());
        }

        return back();
    }

    private function checkAccess(Ticket $ticket): void
    {
        if (! Gate::allows('manage-own-ticket', $ticket)) {
            abort(403);
        }
    }
}
