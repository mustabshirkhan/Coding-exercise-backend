<?php
namespace App\Repositories\User;

/**
 *
 */

interface UserRepositoryInterface
{
    public function getById($id);

    public function getByEmail($email);

    public function create(array $data);

}

