<?php

declare(strict_types=1);

namespace App\Http\Controllers\Profile;

use App\Exceptions\PermsissionDeniedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Ticket\CreateRequest;
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
        $user = Auth::user();
        $ticketTypes = Type::all();

        return view('tickets.index', compact('ticketTypes', 'user'));
    }

    public function view(Ticket $ticket)
    {
        return view('tickets.view', compact('ticket'));
    }

    public function create()
    {
        $types = Type::query()->get();

        return view('tickets.create', compact('types'));
    }

    public function destroy(Ticket $ticket)
    {
        $this->checkAccess($ticket);
        try {
            $this->service->removeByOwner($ticket->id);
        } catch (\DomainException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('ticket.index');
    }

    public function store(CreateRequest $request)
    {
        try {
            $ticket = $this->service->create(Auth::id(), $request);
        } catch (\DomainException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('ticket.view', $ticket);
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
        } catch (PermsissionDeniedException $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], $e->getStatusCode());
        } catch (\DomainException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('ticket.view', ['ticket' => $ticket->id]);
    }

    private function checkAccess(Ticket $ticket): void
    {
        if (! Gate::allows('manage-own-ticket', $ticket)) {
            if (! Gate::allows('manage-tickets')) {
                throw new PermsissionDeniedException();
            }
        }
    }
}
