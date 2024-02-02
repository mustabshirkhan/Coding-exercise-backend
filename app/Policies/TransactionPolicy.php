<?php

namespace App\Policies;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransactionPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }

    public function create(User $user): bool
    {
        return $user->role == 'admin';
    }

    public function view(User $user): bool
    {
        return $user->role == 'admin';
    }
}
