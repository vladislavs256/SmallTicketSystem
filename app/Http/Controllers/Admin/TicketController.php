<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ticket\MessageRequest;
use App\Models\Tickets\Ticket;
use App\Services\Ticket\TicketService;
use Illuminate\Support\Facades\Auth;

final class TicketController extends Controller
{
    public function __construct(
        private TicketService $service
    ) {
    }
    public function reopen(Ticket $ticket)
    {
        $this->checkAccess($ticket);
        try {
            $this->service->reopen(Auth::id(), $ticket->id);
        }catch (\DomainException $e) {
            return back()->with('error', $e->getMessage());
        }
        return back();
    }
    public function message(Ticket $ticket, MessageRequest $request)
    {
        try {
            $this->service->message(Auth::id(), $ticket->id, $request);
        } catch (\DomainException $e) {
            return back()->with('error', $e->getMessage());
        }
            return back();
    }
}
