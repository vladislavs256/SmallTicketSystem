<?php

declare(strict_types=1);

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\Tickets\Ticket;

final class CommentController extends Controller
{
    public function index(Ticket $ticket)
    {
        $message = $ticket->messages()->orderBy('id')->with('user')->get()->last();

        return view('messages.index', compact('message'))->render();
    }
}
