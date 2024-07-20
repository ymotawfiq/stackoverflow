<?php

namespace App\Services\AuthService\RolesService;

use App\Models\ResponseModel\Response;
use App\Models\User;
use App\Models\UserRoles;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class RolesService implements RolesServiceInterface
{
    public function assignRolesToUser(User $user, array $roles=['USER']) : JsonResponse{
        try{
            foreach ($roles as $role_name) {
                $role = DB::table('roles')
                ->where('name', strtoupper($role_name))
                ->get()->first();
                if(empty($role) || $role===null){
                    return response()->json(Response::_404_not_found_('role not found ('. $role_name . ')'));
                }
                if($this->isUserInRole($user, $role_name)){
                    return response()->json(
                        Response::_500_internel_server_error_('user already assigned to this role'));
                }
                DB::table('user_roles')->insert([
                    'role_id'=>$role->id,
                    'user_id'=>$user->id
                ]);
            }
            return response()->json(Response::_201_created_('roles assigned to user successfully'));
        }
        catch(Exception $e){
            return response()->json(Response::_500_internel_server_error_($e->getMessage()));   
        }
    }
    public function isUserInRole(User $user, string $role_name='USER') : bool{
        $role = DB::table('roles')->where('name', strtoupper($role_name))->get()->first();
        if(empty($role) || $role === null){
            return false;
        }
        $user_role = UserRoles::where(['role_id'=>$role->id, 'user_id'=>$user->id])->get()->first();
        if(empty($user_role) && $user_role === null){
            return false;
        }
        return true;
    }
    public function getUserRoles(User $user) : JsonResponse{
        try{
            $user_roles = DB::table('user_roles')->where('user_id', $user->id)->get();
            if(empty($user_roles) || $user_roles === null){
                return response()->json(Response::_204_no_content_('no roles found'));
            }
            return response()->json(
                Response::_200_success_('roles found successfully', $user_roles)
            );
        }
        catch(Exception $e){
            return response()->json(Response::_500_internel_server_error_($e->getMessage()));   
        }
    }
    public function getUserRolesNames(User $user) : array{
        $user_roles = DB::table('user_roles')->where('user_id', $user->id)->get();
        $roles_names=[];
        if(empty($user_roles) || $user_roles === null){
            return $roles_names;
        }
        foreach($user_roles as $user_role){
            $role = DB::table('roles')->where(['id'=>$user_role->role_id])->get()->first();
            array_push($roles_names, $role->name);
        }
        return $roles_names;
    }
}
