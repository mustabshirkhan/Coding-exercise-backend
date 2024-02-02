<?php

namespace App\Http\Controllers\API\v1;

use App\Services\AuthService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService)
    {
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        try {
            $userData = $request->only('name', 'email', 'password');
            $user = $this->authService->register($userData);
            return response(['user' => $user], 201);
        } catch (ValidationException $e) {
            return response(['error' => $e->getMessage()], $e->status);
        } catch (\Exception $e) {
            return response(['error' => 'Something went wrong'], 500);
        }
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
     */

    public function login(Request $request)
    {
        try {
            $credentials = $request->only('email', 'password');
            return $this::success($this->authService->attemptLogin($credentials), 'Logged In', 200);
        } catch (ValidationException $e) {
            // Handle validation exception
            return response(['error' => $e->getMessage()], $e->getCode());
        } catch (\Exception $e) {
            // Handle other exceptions if necessary
            return response(['error' => 'Something went wrong'], $e->getCode());
        }
    }
}
