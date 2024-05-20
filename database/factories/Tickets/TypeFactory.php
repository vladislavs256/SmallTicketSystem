<?php

declare(strict_types=1);

namespace database\factories\Tickets;

use App\Models\Tickets\Type;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tickets\Type>
 */
class TypeFactory extends Factory
{
    protected $model = Type::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->titleMale(),
        ];
    }
}
