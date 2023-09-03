<?php
declare(strict_types=1);

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\Tickets\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

final class TicketController extends Controller
{


    public function index()
    {
        $tickets = Ticket::forUser(Auth::user())->orderByDesc('updated_at')->paginate(20);
        return view('tickets.index', compact('tickets'));
    }
}
