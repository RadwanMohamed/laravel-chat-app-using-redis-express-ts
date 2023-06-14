<?php

namespace App\Repositories;

use App\Models\User as Model;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class User
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
    public function find(int $id) : Model
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Find a user by phone.
     *
     * @return string $phone
     *
     * @return Model
     */
    public function findByPhone(string $phone)
    {
        return $this->model->wherePhone($phone)->firstOrFail();
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
     * update user socket
     * @param int $userId
     * @param array $data
     * @return bool
     */
    public function updateSocketId(int $userId,array $data,){
        $user = $this->find($userId);
        return $user->update($data);
    }
}
