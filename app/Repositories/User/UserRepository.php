<?php

namespace App\Repositories\User;
use App\Models\User;


class UserRepository implements UserRepositoryInterface
{

    public function getById($id)
    {
        return User::find($id);
    }

    public function getByEmail($email)
    {
        return User::where('email', $email)->first();
    }

    public function create(array $data)
    {
        return User::create($data);
    }

}
