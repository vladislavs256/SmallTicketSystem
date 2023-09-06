<?php

declare(strict_types=1);

namespace App\Models\Tickets;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Type extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    protected $table = 'ticket_types';

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public static function new(string $name): self
    {
        $type = self::create([
            'name' => $name,
        ]);

        return $type;
    }

    public function edit(string $name): void
    {
        $this->update([
            'name' => $name,
        ]);
    }
}
