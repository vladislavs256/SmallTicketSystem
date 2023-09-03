<?php

namespace App\Models\Tickets;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'ticket_tickets';
    protected $fillable = ['user_id', 'subject', 'content', 'status', 'type_id', 'attached_files'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id');
    }

    public function statuses()
    {
        return $this->hasMany(Status::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }



    public static function new(int $userId, string $subject, string $content): self
    {
        $ticket = self::create([
            'user_id' => $userId,
            'subject' => $subject,
            'content' => $content,
            'status' => Status::OPEN,
        ]);
        $ticket->setStatus(Status::OPEN, $userId);
        return $ticket;
    }

    public function edit(string $subject, string $content): void
    {
        $this->update([
            'subject' => $subject,
            'content' => $content,
        ]);
    }

    public function addMessage(int $userId, $message): void
    {
        if (!$this->allowsMessages()) {
            throw new \DomainException('Ticket is closed for messages.');
        }
        $this->messages()->create([
            'user_id' => $userId,
            'message' => $message,
        ]);
        $this->update();
    }

    public function allowsMessages(): bool
    {
        return !$this->isClosed();
    }

    public function approve(int $userId): void
    {
        if ($this->isApproved()) {
            throw new \DomainException('Ticket is already approved.');
        }
        $this->setStatus(Status::APPROVED, $userId);
    }

    public function close(int $userId): void
    {
        if ($this->isClosed()) {
            throw new \DomainException('Ticket is already closed.');
        }
        $this->setStatus(Status::CLOSED, $userId);
    }

    public function reopen(int $userId): void
    {
        if (!$this->isClosed()) {
            throw new \DomainException('Ticket is not closed.');
        }
        $this->setStatus(Status::APPROVED, $userId);
    }

    public function isOpen(): bool
    {
        return $this->status === Status::OPEN;
    }

    public function isApproved(): bool
    {
        return $this->status === Status::APPROVED;
    }

    public function isClosed(): bool
    {
        return $this->status === Status::CLOSED;
    }

    public function canBeRemoved(): bool
    {
        return $this->isOpen();
    }


    private function setStatus($status, ?int $userId): void
    {
        $this->statuses()->create(['status' => $status, 'user_id' => $userId]);
        $this->update(['status' => $status]);
    }

    public function scopeForUser(Builder $query, User $user)
    {
        return $query->where('user_id', $user->id);

    }
}
