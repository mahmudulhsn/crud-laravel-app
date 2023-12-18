<?php

namespace App\Interfaces;

use App\Models\User;

interface AuthRepositoryInterface
{

    /**
     * Register user interface
     *
     * @param array $userData
     * @return User
     */
    public function register(array $userData): User;

    /**
     * Login user interface
     *
     * @param string $email
     * @param string $password
     * @return User|null
     */
    public function login(string $email, string $password): User|null;

    /**
     * Authenticate user interface
     *
     * @return User|null
     */
    public function getAuthenticatedUser(?array $relationNames = []): User|null;
}
