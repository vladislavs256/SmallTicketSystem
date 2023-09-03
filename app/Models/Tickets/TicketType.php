<?php
declare(strict_types=1);

namespace App\Models\Tickets;

use Illuminate\Database\Eloquent\Model;

final class TicketType extends Model
{
    protected $fillable = ['name'];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
