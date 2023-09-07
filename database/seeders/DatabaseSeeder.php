<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Tickets\Ticket;
use App\Models\Tickets\Type;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
        Type::factory(3)->create();

        Ticket::factory(100)->create();

        //        User::factory()->create([
        //            'name' => 'admin',
        //            'email' => 'admin@email.com',
        //            'email_verified_at' => now(),
        //            'status' => 'active',
        //            'role' => 'admin',
        //            'password' => Hash::make('admin123'),
        //            'remember_token' => Str::random(10),
        //        ]);
    }
}
