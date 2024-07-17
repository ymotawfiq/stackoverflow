<?php

namespace App\Services\AuthService\RolesService;

use App\Models\User;
use Illuminate\Http\JsonResponse;

interface RolesServiceInterface
{
    public function assign_roles_to_user(User $user, array $roles) : JsonResponse;
    public function is_user_in_role(User $user, string $role_name) : bool;
    public function get_user_roles(User $user) : JsonResponse;
    public function get_user_roles_names(User $user) : array;
}
