<?php

namespace App\Services;

use Illuminate\Support\Str;
use App\Models\User as UserModel;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\UserResource;
use App\Repositories\User as UserRepo;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth as AuthFacade;

class Auth
{
    /**
     * Register a new user.
     *
     * @param \App\Repositories\User
     */
    public function __construct(protected UserRepo $user)
    {
        $this->user = $user;
    }

    /**
     * Login a user.
     *
     * @param string $phone
     * @param string $password
     * @throws \Illuminate\Validation\ValidationException
     *
     * @return array
     */
    public function login(string $phone, string $password): ValidationException|array
    {
        $phone = $this->validateCredential($phone, $password);

        $user = $this->user->findByPhone($phone);

        return ['token' => $this->createToken($user), 'user' => UserResource::make($user)];
    }

    /**
     * Fetch the authenticated user.
     *
     * @return \App\Models\User auth model instance
     */
    public function fetchAuthUser(): UserModel
    {
        return auth('sanctum')->user();
    }

    /**
     * Create token.
     *
     * @param \App\Models\User $user
     *
     * @return string authentication token
     */
    protected function createToken(UserModel $user): string
    {
        return $user->createToken('amtiaz')->plainTextToken;
    }

    /**
     * Validate user credential.
     *
     * @param string $phone
     * @param string $password
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateCredential(string $phone, string $password): string
    {
        if (str_starts_with($phone, '5') || str_starts_with($phone, '05')) {
            $phone = '966' . Str::substr($phone, strpos($phone, '5'));
        }
        //TODO: remove message to handler
        if (!AuthFacade::attempt(['phone' => $phone, 'password' => $password])) {
            throw ValidationException::withMessages([
                'phone' => __('passwords.phone'),
                'password' => __('auth.failed'),
            ]);
        }

        return $phone;
    }

    /**
     * Fetch the authenticated user.
     *
     * @return void
     */
    public function logout(): void
    {
        $this->fetchAuthUser()->tokens()->delete();
    }
}
