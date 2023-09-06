<?php

namespace database\factories\Tickets;

use App\Models\Tickets\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tickets\Ticket>
 */
class TicketFactory extends Factory
{
    protected $model = Ticket::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => random_int(1, 10),
            'subject' => fake()->title(),
            'content' => fake()->text(),
            'status' => 'new',
            'type_id' => random_int(1,3),
            'attached_files' => null,
        ];
    }
}
