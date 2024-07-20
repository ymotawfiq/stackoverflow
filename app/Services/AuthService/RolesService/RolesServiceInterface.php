<?php

namespace App\Services\AuthService\RolesService;

use App\Models\User;
use Illuminate\Http\JsonResponse;

interface RolesServiceInterface
{
    public function assignRolesToUser(User $user, array $roles) : JsonResponse;
    public function isUserInRole(User $user, string $role_name) : bool;
    public function getUserRoles(User $user) : JsonResponse;
    public function getUserRolesNames(User $user) : array;
}
