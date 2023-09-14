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
    ) {
        $this->middleware('can:manage-tickets');
    }

    public function index()
    {
        $user = Auth::user();
        $ticketTypes = Type::all();

        return view('tickets.index', compact('ticketTypes', 'user'));

    }


}
