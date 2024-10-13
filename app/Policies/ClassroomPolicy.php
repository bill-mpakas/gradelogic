<?php

namespace App\Policies;

use App\Models\Classroom;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ClassroomPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user, Classroom $classroom): Response
    {
        // default response
//        return Response::allow('You are authorized to view classrooms', 200);

    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(): Response
    {
        // if the authenticated user has the permission to read classrooms then they can view the classrooms
//        if($Auth->hasPermissionTo('read classrooms', 'api')) {
//            return Response::allow();
//        }
//        if($user->hasPermissionTo('read classrooms', 'api') && $user->classrooms->contains($classroom)) {
//            return Response::allow();
//        }
//        return Response::deny(401);
//        return $user->id === $classroom->user_id
//            ? Response::allow()
//            : Response::deny('You are not authorized to view this classroom', 404);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {

        if($user->hasPermissionTo('create classrooms', 'api')) {
            return Response::allow();
        }
        return Response::deny('You are not authorized to create a classroom', 401);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Classroom $classroom): Response
    {
        // the user must be assigned to the classroom either as a teacher or student
        if($user->hasPermissionTo('update-classrooms', 'api')  && $user->classrooms->contains($classroom)) {
            return Response::allow();
        }
        return Response::deny('You are not authorized to update this classroom', 404);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Classroom $classroom): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Classroom $classroom): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Classroom $classroom): bool
    {
        //
    }
}
