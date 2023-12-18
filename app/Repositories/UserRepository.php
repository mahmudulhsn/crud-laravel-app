<?php

namespace App\Repositories;

use App\Models\User;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserRepositoryInterface
{

    /**
     * UserRepository constructor.
     *
     * @param User $model
     */
    public function __construct(protected User $model)
    {
        $this->model = $model;
    }

    /**
     * Return all the user
     *
     * @param array|null $relationNames
     * @return Collection
     */
    public function getAllUsers(?array $relationNames = []): Collection
    {
        $user = $this->model->query();
        if ($relationNames !== []) {
            $user->with($relationNames);
        }
        return $user->oldest('name')->get();
    }

    /**
     * Create new user and return the user object
     *
     * @param array $userDetails
     * @return User
     */
    public function createUser(array $userDetails): User
    {
        return $this->model->create($userDetails);
    }

    /**
     * Find user by ID and return the user object
     *
     * @param integer $userID
     * @param array|null $relationNames
     * @return User
     */
    public function getUserById(int $userID, ?array $relationNames = []): User
    {
        $user = $this->model->query();
        if ($relationNames !== []) {
            $user->with($relationNames);
        }

        return $user->where('id', $userID)->latest()->first();
    }

    /**
     * Update user
     *
     * @param object $user
     * @param array $newDetails
     * @return boolean
     */
    public function updateUser(object $user, array $newDetails): bool
    {
        return $user->update($newDetails);
    }

    /**
     * Delete a single user
     *
     * @param object $user
     * @return boolean
     */
    public function deleteUser(object $user): bool
    {
        return $user->delete();
    }
}
