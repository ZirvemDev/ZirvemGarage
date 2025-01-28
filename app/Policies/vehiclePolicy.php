<?php

namespace App\Policies;

use App\Models\User;
use App\Models\vehicle;
use Illuminate\Auth\Access\HandlesAuthorization;

class vehiclePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, vehicle $vehicle): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, vehicle $vehicle): bool
    {
    }

    public function delete(User $user, vehicle $vehicle): bool
    {
    }

    public function restore(User $user, vehicle $vehicle): bool
    {
    }

    public function forceDelete(User $user, vehicle $vehicle): bool
    {
    }
}
