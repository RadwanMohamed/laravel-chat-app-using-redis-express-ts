<?php

namespace App\Services;

use Illuminate\Support\Str;
use App\Models\User as UserModel;
use App\Repositories\User;
use Illuminate\Support\Facades\Hash;
use App\Support\DataTransferObjects\UserRegisterDTO;

class Register
{
    /**
     * Register a new user.
     *
     * @param \App\Repositories\User
     *
     * @return void
     */
    public function __construct(protected User $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    /**
     * Create user instance.
     *
     * @param array $userData
     *
     * @return \App\Models\User
     */
    public function register(array $data ): UserModel
    {
        return $this->userRepo->create($data);
    }
}
