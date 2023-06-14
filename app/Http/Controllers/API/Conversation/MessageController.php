<?php

namespace App\Http\Controllers\API\Conversation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Conversation\MessageListRequest;
use App\Http\Requests\Conversation\MessageRequest;
use App\Http\Resources\MessageResource;
use App\Services\MessageService;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Class constructor.
     *
     * @param \App\Repositories\User $user
     *
     * @return void
     */
    public function __construct(protected MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    /**
     * send message
     * @param MessageRequest $request
     * @return \Illuminate\Http\Response
     */

    public function sendMessage(MessageRequest $request)
    {
        $message = $this->messageService->sendMessage($request->validated());
        return response()->noContent();
    }

    /**
     * get all messages
     * @param MessageListRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getMessages(MessageListRequest $request){
        return MessageResource::collection($this->messageService->getConversationMessages($request->receiver_id,$request->sender_id));
    }

}
