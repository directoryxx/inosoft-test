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
}