<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ApiController;
use App\Interfaces\AuthRepositoryInterface;

class AuthController extends ApiController
{
    /**
     * AuthController Constructor
     *
     * @param AuthRepositoryInterface $authRepository
     */
    public function __construct(protected AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    /**
     * Return the token and current user information
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $loginData = $request->validated();
        $user = $this->authRepository->login($loginData['email'], $loginData['password']);
        if ($user) {
            return $this->sendResponse('User has been logged in successfully.', ['user' => $user], 200);
        } else {
            return $this->sendError('Unautorized.', ['error' => 'Unautorized'], 401);
        }
    }

    /**
     * Return authenticated user information
     *
     * @return JsonResponse
     */
    public function me(): JsonResponse
    {
        $authUser = $this->authRepository->getAuthenticatedUser();
        if ($authUser) {
            return $this->sendResponse('Current authenticated user info.', ["user" => $authUser], 200);
        } else {
            return $this->sendError('Unautorized.', ['error' => 'Unautorized'], 401);
        }
    }

    /**
     * Logout
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        Auth::user()->tokens()->delete();
        return $this->sendResponse('User has been logged out successfully.', [], 200);
    }
}
