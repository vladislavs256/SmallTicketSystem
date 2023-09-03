<?php
declare(strict_types=1);

namespace App\Models\Tickets;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

final class Status extends Model
{
    public const OPEN = 'open';
    public const APPROVED = 'approved';
    public const CLOSED = 'closed';

    protected $table = 'ticket_statuses';
    protected $fillable = ['ticket_id', 'user_id', 'status'];

    public static function statusesList(): array
    {
        return [
            self::OPEN => 'Open',
            self::APPROVED => 'Approved',
            self::CLOSED => 'Closed',
        ];
    }

    public function isOpen(): bool
    {
        return $this->status === self::OPEN;
    }

    public function isApproved(): bool
    {
        return $this->status === self::APPROVED;
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
