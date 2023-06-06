<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;
use Jenssegers\Mongodb\Eloquent\Builder;

class UserRepository
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function filter(array $filter) : Builder
    {
        return $this->user
        ->when(has_key('email', $filter), function ($query) use ($filter) {
            return $query->where('email', $filter['email']);
        });
    }

    public function create(array $user) : User
    {
        return $this->user->create($user);
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
        return auth()->user();
    }
}