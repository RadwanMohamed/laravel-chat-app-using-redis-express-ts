<?php

namespace App\Services;

use App\Events\SendMessageEvent;
use App\Repositories\MessageRepository;
use App\Repositories\User;

class MessageService
{
    /**
     * message constructor
     *
     */
    public function __construct(protected MessageRepository $messageRepository, protected User $userRepository,protected EncryptionService $encryptionService)
    {
        $this->messageRepository = $messageRepository;
        $this->userRepository = $userRepository;
        $this->encryptionService = $encryptionService;
    }

    /**
     * send message
     * @param array $data
     * @return \App\Models\Message|null
     */
    public function sendMessage(array $data)
    {
        $data['sender_id'] = auth()->id();
        $receiver  = $this->userRepository->find($data['receiver_id']);
        $data['socketId'] = $receiver->socketId;
        $data['message'] = $this->encryptionService->encrypt($data['message']);
        $message = $this->messageRepository->create($data);
        event(new SendMessageEvent($data));
        return $message;
    }

    /**
     * get all conversation messages
     * @param $senderId
     * @param $receiverId
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getConversationMessages($senderId,$receiverId){
        return $this->messageRepository->getConversationMessages($senderId,$receiverId);
    }
}
