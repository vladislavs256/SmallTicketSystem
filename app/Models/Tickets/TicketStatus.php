<?php
declare(strict_types=1);

namespace App\Models\Tickets;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

final class TicketStatus extends Model
{
    protected $fillable = ['ticket_id', 'user_id', 'status'];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
