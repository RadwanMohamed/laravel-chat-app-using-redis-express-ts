<?php

namespace App\Repositories;

use App\Models\Message as Model;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class MessageRepository
{
    /**
     * Class constructor.
     *
     * @param Model $model
     */
    public function __construct(private Model $model)
    {
        $this->model = $model;
    }

    /**
     * Find a user by id.
     *
     * @return int $id
     *
     * @return Model
     */
    public function find(int $id)
    {
        return $this->model->findOrFail($id);
    }



    /**
     * Create a new resource.
     *
     * @param array $data
     * @return Model
     */
    public function create(array $data): ?Model
    {
        $model = $this->model->create($data);

        return $model->fresh();
    }

    /**
     * delete vision.
     *
     * @param int $id
     */
    public function delete($id)
    {
        $this->model->findOrFail($id)->delete();
    }

    /**
     * get message between users orderBy desc
     * @param $senderId
     * @param $receiver
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getConversationMessages($senderId,$receiver){
       return  Model::query()
            ->where(function ($query) use ($senderId,$receiver) {
                return $query->where('sender_id', $senderId)
                    ->where('receiver_id', $receiver);
            })->orWhere(function ($query) use ($senderId,$receiver) {
                return $query->where('sender_id', $senderId)
                    ->where('receiver_id', $receiver);
            })->orderBy("created_at","desc")->get();
    }
}
