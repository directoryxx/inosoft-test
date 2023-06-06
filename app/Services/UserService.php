<?php

namespace App\Services;

use App\Repositories\PermitRepository;
use App\Repositories\UserRepository;

class UserService {
    public $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function createToken($user) {
        return $this->userRepository->createToken($user);
    }

    public function checkEmail($email) {
        return $this->userRepository->filter(["email" => $email])->first();
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