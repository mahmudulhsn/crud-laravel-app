<?php

namespace App\Interfaces;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    /**
     * Return all users
     *
     * @param array $relationship
     * @return Collection
     */
    public function getAllUsers(?array $relationNames = []): Collection;

    /**
     * Create a new user
     *
     * @param array $userDetails
     * @return User
     */
    public function createUser(array $userDetails): User;

    /**
     * Find user user by id and return user
     *
     * @param integer $userID
     * @param array|null $relationNames
     * @return User
     */
    public function getUserById(int $userID, ?array $relationNames = []): User;

    /**
     * Update a a user
     *
     * @param object $user
     * @param array $newDetails
     * @return boolean
     */
    public function updateUser(object $user, array $newDetails): bool;

    /**
     * Delete a user
     *
     * @param object $user
     * @return boolean
     */
    public function deleteUser(object $user): bool;
}
