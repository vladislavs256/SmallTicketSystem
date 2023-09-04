<?php
declare(strict_types=1);

namespace App\Services\Ticket;

use App\Models\Tickets\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

final class TicketService
{
    public function getTicketsData(Request $request)
    {
        $query = Ticket::query();
        $query = $this->applyFilters($request, $query);
        $query = $this->applySorting($request, $query);

        $tickets = $this->paginateResults($request, $query);

        $responseData = [
            'draw' => $request->input('draw'),
            'recordsTotal' => $tickets->total(),
            'recordsFiltered' => $tickets->total(),
            'data' => $this->formatTicketData($tickets),
        ];

        return $responseData;
    }

    private function applyFilters(Request $request, $query)
    {
        if ($request->has('search.value')) {
            $query->where('subject', 'like', '%' . $request->input('search.value') . '%');
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
                'created_at' => $ticket->created_at->format("d/m/Y"),
                'updated_at' => $ticket->updated_at->format("d/m/Y"),
                'status' => $ticket->status,
                'link' => route('ticket.view', ['ticket' => $ticket->id])
            ];
        });
    }


}
