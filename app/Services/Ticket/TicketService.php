<?php

declare(strict_types=1);

namespace App\Services\Ticket;

use App\Http\Requests\Ticket\CreateRequest;
use App\Http\Requests\Ticket\EditRequest;
use App\Http\Requests\Ticket\MessageRequest;
use App\Models\Tickets\Attachment;
use App\Models\Tickets\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

final class TicketService
{

    public function approve(int $userId, int $id): void
    {
        $ticket = $this->getTicket($id);
        $ticket->approve($userId);
    }

    public function close(int $userId, int $id): void
    {
        $ticket = $this->getTicket($id);
        $ticket->close($userId);
    }

    public function reopen(int $userId, int $id): void
    {
        $ticket = $this->getTicket($id);
        $ticket->reopen($userId);
    }
    public function removeByOwner(int $id): void
    {
        $ticket = $this->getTicket($id);
        if (!$ticket->canBeRemoved()) {
            throw new \DomainException('Unable to remove active ticket');
        }
        $ticket->delete();
    }

    public function removeByAdmin(int $id): void
    {
        $ticket = $this->getTicket($id);
        $ticket->delete();
    }


    public function edit(int $id, EditRequest $request): void
    {
        $ticket = $this->getTicket($id);
        $ticket->edit(
            $request['subject'],
            $request['content']
        );
    }

    private function storeAttachments(CreateRequest $request, Ticket $ticket)
    {
        if ($request->hasFile('attachments')) {
            $attachments = [];

            $files = is_array($request->file('attachments'))
                ? $request->file('attachments')
                : [$request->file('attachments')];

                foreach ($files as $attachment) {
                    $path = $attachment->store('attachments');
                    $attachments[] = [
                        'filename' => $attachment->getClientOriginalName(),
                        'mime_type' => $attachment->getMimeType(),
                        'size' => $attachment->getSize(),
                        'path' => $path,
                        'ticket_id' => $ticket->id
                    ];
                }
            Attachment::insert($attachments);
        }
    }
    public function create(int $userId, CreateRequest $request): Ticket
    {

       $ticket = Ticket::new($userId,
            $request['subject'],
            $request['content'],
            (int)$request['type'],
        );
        $this->storeAttachments($request, $ticket);
        return $ticket;
    }

    public function message(int $userId, int $id, MessageRequest $request): void
    {
        $ticket = $this->getTicket($id);
        $ticket->addMessage($userId, $request['message']);
    }

    public function getTicketsData(Request $request)
    {
        $query = Ticket::query();
        $query = $this->applyFilters($request, $query);
        $query = $this->applySorting($request, $query);

        $tickets = $query->get();
        $responseData = [
            'recordsTotal' => $tickets->count(),
            'recordsFiltered' => $tickets->count(),
            'data' => $this->formatTicketData($tickets),
        ];

        return $responseData;
    }

    private function applyFilters(Request $request, $query)
    {
        if ($request->has('search.value')) {
            $query->where('subject', 'like', '%'.$request->input('search.value').'%');
        }

        return $query;
    }

    private function applySorting(Request $request, $query)
    {
        if ($request->has('order')) {
            $orderByColumn = $request->input('columns')[$request->input('order.0.column')]['data'];
            $orderDirection = $request->input('order.0.dir');
            $query->orderBy($orderByColumn, $orderDirection);
        }

        return $query;
    }

    private function paginateResults(Request $request, $query)
    {
        return $query->paginate($request->input('length'));
    }

    private function formatTicketData($tickets)
    {
        return $tickets->map(function ($ticket) {
            return [
                'id' => $ticket->id,
                'subject' => $ticket->subject,
                'content' => Str::limit($ticket->content, 50),
                'type_name' => $ticket->typeName(),
                'created_at' => $ticket->created_at->format('d/m/Y'),
                'updated_at' => $ticket->updated_at->format('d/m/Y'),
                'status' => $ticket->status,
                'link' => route('ticket.view', ['ticket' => $ticket->id]),
            ];
        });
    }

    private function getTicket($id): Ticket
    {
        return Ticket::findOrFail($id);
    }
}
