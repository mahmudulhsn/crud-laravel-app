<?php

namespace App\Repositories;

use App\Http\Resources\RoleResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\AuthRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class AuthRepository implements AuthRepositoryInterface
{
    /**
     * @var $model
     */
    protected $model;

    /**
     * AuthRepository constructor.
     *
     * @param User $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * Register a new user ans return the user with access token
     *
     * @param array $userData
     * @return User
     */
    public function register(array $userData): User
    {
        $userData['password'] = bcrypt($userData['password']);
        $userData['email_verified_at'] = now();
        $user = $this->model->create($userData);
        $userData['accessToken'] = $user->createToken('API Token')->accessToken;

        return $user;
    }

    /**
     * Login a user ans return the user with access token
     *
     * @param string $email
     * @param string $password
     * @return User|null
     */
    public function login(string $email, string $password): User|null
    {
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            $user = Auth::user();
            $user['accessToken'] = $user->createToken('MyApp')->accessToken;
            return $user;
        } else {
            return null;
        }
    }

    /**
     * Return the authenticated user
     *
     * @return User|null
     */
    public function getAuthenticatedUser(?array $relationNames = []): User|null
    {
        $user = auth()->user();
        return $user;
    }
}
