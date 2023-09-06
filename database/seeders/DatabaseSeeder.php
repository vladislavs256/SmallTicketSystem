<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Tickets\Ticket;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(1)->create();

        Ticket::factory(100)->create();

        \App\Models\User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@email.com',
            'email_verified_at' => now(),
            'status' => 'active',
            'role' => 'admin',
            'password' => '$2y$10$9fqocH7TjG2AkFeYcWs27ekBURGKTop5WI2jwhuSYSrPa0WhV.4j6', // password
            'remember_token' => Str::random(10),
        ]);
    }
}
