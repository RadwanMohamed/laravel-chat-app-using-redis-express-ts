<?php

namespace App\Http\Controllers\API\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\Auth as AuthService;
use App\Http\Requests\Auth\LoginRequest;

class AuthController extends Controller
{
    /**
     * Class constructor.
     *
     * @param \App\Repositories\User $user
     *
     * @return void
     */
    public function __construct(protected AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * login user to application.
     *
     * @param \App\Http\Requests\API\V1\Auth\LoginRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $user = $this->authService->login($request->input('phone'), $request->input('password'));

        return response()->json($user, JsonResponse::HTTP_CREATED);
    }
}
