<?php

namespace App\Policies;

use App\Models\Rapper;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Log;

class RapperPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        $permission = strpos($user->group->permission, "rappers_view");
        return !is_int($permission);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Rapper  $rapper
     * @return mixed
     */
    public function view(User $user, Rapper $rapper)
    {
        $permission = strpos($user->group->permission, "rappers_view");
        return !is_int($permission);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        $permission = strpos($user->group->permission, "rappers_create");
        return !is_int($permission);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Rapper  $rapper
     * @return mixed
     */
    public function update(User $user, Rapper $rapper)
    {
        $permission = strpos($user->group->permission, "rappers_update");
        return !is_int($permission);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Rapper  $rapper
     * @return mixed
     */
    public function delete(User $user, Rapper $rapper)
    {
        $permission = strpos($user->group->permission,"rappers_delete");
        return !is_int($permission);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Rapper  $rapper
     * @return mixed
     */
    public function restore(User $user, Rapper $rapper)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Rapper  $rapper
     * @return mixed
     */
    public function forceDelete(User $user, Rapper $rapper)
    {
        //
    }
}
