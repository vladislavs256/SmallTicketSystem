<?php

declare(strict_types=1);

namespace App\Models\Tickets;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

final class Status extends Model
{
    public const NEW = 'new';

    public const PROGRESS = 'in progress';

    public const CLOSED = 'closed';

    protected $table = 'ticket_statuses';

    protected $fillable = ['ticket_id', 'user_id', 'status'];

    public static function statusesList(): array
    {
        return [
            self::NEW => 'New',
            self::PROGRESS => 'In Progress',
            self::CLOSED => 'Closed',
        ];
    }

    public function isOpen(): bool
    {
        return $this->status === self::NEW;
    }

    public function isApproved(): bool
    {
        return $this->status === self::PROGRESS;
    }

    public function isClosed(): bool
    {
        return $this->status === self::CLOSED;
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
