<?php

declare(strict_types=1);
namespace App\Services;

use App\Repositories\UserRepository;

class UserService {
    public $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function createToken($user) {
        return $this->userRepository->createToken($user);
    }

    public function checkEmail(string $email) : \Jenssegers\Mongodb\Eloquent\Builder {
        return $this->userRepository->filter(["email" => $email]);
    }

    public function createUser($user) {
        return $this->userRepository->create($user);
    }

    public function logout() {
        return $this->userRepository->logout();
    }

    public function profile() {
        return $this->userRepository->profile();
    }
}