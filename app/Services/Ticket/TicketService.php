<?php
declare(strict_types=1);

namespace App\Services\Ticket;

use App\Models\Tickets\Ticket;
use Illuminate\Http\Request;

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
                'content' => $ticket->content,
                'type_name' => $ticket->typeName(),
                'created_at' => $ticket->created_at,
                'updated_at' => $ticket->updated_at,
                'status' => $ticket->status,
            ];
        });
    }


}
