<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Tickets\Ticket;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('manage-own-ticket', function (User $user, Ticket $ticket) {
            return $ticket->user_id === $user->id;
        });

        Gate::define('manage-tickets', function (User $user) {
            return $user->isAdmin() || $user->isModerator();
        });
    }
}
