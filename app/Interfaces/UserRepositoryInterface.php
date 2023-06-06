<?php

namespace App\Interfaces;

use App\Models\User;

interface UserRepositoryInterface
{
    public function filter(array $filter);
    public function create(array $user);
    public function createToken(User $user);
    public function logout();
    public function profile();
}