<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function filter(array $filter)
    {
        return User::
        when(has_key('email', $filter), function ($query) use ($filter) {
            return $query->where('email', $filter['email']);
        });
    }

    public function create(array $user)
    {
        return User::create($user);
    }

    public function createToken(User $user) : string
    {
        return $user->createToken('auth_token')->plainTextToken;
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
    }

    public function profile()
    {
        auth()->user();
    }
}