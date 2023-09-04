<?php

declare(strict_types=1);

namespace App\Models\Tickets;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

final class Message extends Model
{
    protected $fillable = ['ticket_id', 'user_id', 'message'];

    protected $table = 'ticket_messages';

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
