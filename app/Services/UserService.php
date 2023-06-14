<?php

namespace App\Services;

use App\Events\SendMessageEvent;
use App\Repositories\MessageRepository;
use App\Repositories\User;

class UserService
{
    /**
     * message constructor
     *
     */
    public function __construct( protected User $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * store socketId & switch status
     * @param array $data
     * @return void
     */
    public function changeUserStatus(array $data){
        $this->userRepository->updateSocketId($data['user_id'],$data);
    }
}
