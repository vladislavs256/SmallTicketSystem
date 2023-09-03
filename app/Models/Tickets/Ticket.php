<?php

namespace App\Models\Tickets;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'subject', 'content', 'status', 'type_id', 'attached_files'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function type()
    {
        return $this->belongsTo(TicketType::class, 'type_id');
    }

    public function statuses()
    {
        return $this->hasMany(TicketStatus::class);
    }

    public function messages()
    {
        return $this->hasMany(TicketMessage::class);
    }
}
