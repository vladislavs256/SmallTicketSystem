<?php

declare(strict_types=1);

namespace App\Http\Controllers\Profile;

use App\Exceptions\PermsissionDeniedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Ticket\MessageRequest;
use App\Models\Tickets\Ticket;
use App\Services\Ticket\TicketService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

final class CommentController extends Controller
{
    public function __construct(
        private TicketService $service
    ) {
    }

    public function index(Ticket $ticket)
    {
        $message = $ticket->messages()->orderBy('id')->with('user')->get()->last();

        return view('messages.index', compact('message'))->render();
    }

    public function create(Ticket $ticket, MessageRequest $request)
    {

        try {
            $this->checkAccess($ticket);
            $this->service->message(Auth::id(), $ticket->id, $request);
        } catch (PermsissionDeniedException $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], $e->getStatusCode());
        } catch (\DomainException $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }

        return response()->json(['success' => true]);
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
