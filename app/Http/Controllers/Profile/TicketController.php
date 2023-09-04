<?php
declare(strict_types=1);

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\Tickets\Ticket;
use App\Models\User;
use App\Services\Ticket\TicketService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

final class TicketController extends Controller
{
    public function __construct(
        private TicketService $service
    )
    {
    }

    public function index()
    {
        $tickets = Ticket::forUser(Auth::user())->orderBy('id')->paginate(20);
        return view('tickets.index', compact('tickets'));
    }

    public function view(Ticket $ticket)
    {
        dd($ticket);
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



}
