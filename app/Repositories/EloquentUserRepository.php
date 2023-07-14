<?php


namespace App\Repositories;


use App\Entities\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class EloquentUserRepository implements UserRepositoryInterface
{

    public function getModel(): User
    {
        return new User();
    }

    public function all($role = false): Collection
    {
        return $role ? $this->getModel()->role($role)->get() : $this->getModel()->all();
    }

    public function findById(int $id): User
    {
        return $this->getModel()->find($id);
    }
}
