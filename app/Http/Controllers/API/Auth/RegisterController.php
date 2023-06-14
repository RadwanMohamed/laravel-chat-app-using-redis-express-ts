<?php

namespace App\Http\Controllers\API\Auth;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\Auth as AuthService;
use App\Services\Register as RegisterService;
use App\Http\Requests\Auth\RegisterRequest;

class RegisterController extends Controller
{
    /**
     * Class constructor.
     *
     * @param \App\Support\Services\Register $registerService
     * @param \App\Support\Services\Auth $authService
     *
     * @return void
     */
    public function __construct(
        protected RegisterService $registerService,
        protected AuthService $authService
    ) {
        $this->registerService = $registerService;
        $this->authService = $authService;
    }

    /**
     * Store a new user.
     *
     * @param \App\Http\Requests\API\V1\Auth\RegisterRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(RegisterRequest $request): JsonResponse
    {

        $this->registerService->register($request->validated());

        $user = $this->authService->login($request->input('phone'), $request->input('password'));

        return response()->json($user, JsonResponse::HTTP_CREATED);
    }
}
