<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;

final class RegisterService
{
    public function register(RegisterRequest $request): void
    {
        $user = User::register(
            $request['name'],
            $request['email'],
            $request['password']
        );

        event(new Registered($user));
        Auth::login($user);

    }

    public function verify($id): void
    {
        /** @var User $user */
        $user = User::findOrFail($id);
        $user->verify();
    }
}
