<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;

class AuthService
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    public function attemptLogin(array $credentials)
    {
        try {
            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                $token = $user->createToken('AuthToken')->accessToken;
                return ['token' => $token];
            }
            throw ValidationException::withMessages(['error' => 'Invalid credentials']);
        } catch (\Exception $e) {
            // Handle other exceptions if necessary
            return response(['error' => 'Something went wrong'], 500);
        }
    }

    public function register(array $userData): User
    {
        try {

            $userData['password'] = Hash::make($userData['password']);
            $user = $this->userRepository->create($userData);
            return $user;

        } catch (\Exception $e) {
            return response(['error' => 'Something went wrong'], 500);
        }
    }
}
