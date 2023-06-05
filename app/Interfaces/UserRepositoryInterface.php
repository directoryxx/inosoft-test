<?php

namespace App\Interfaces;

interface UserRepositoryInterface
{
    public function filter(array $filter);
    public function create(array $user);
}