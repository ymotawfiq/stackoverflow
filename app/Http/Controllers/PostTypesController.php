<?php

namespace App\Http\Controllers;

use App\Models\ResponseModel\Response;
use App\Models\User;
use App\Services\auth_service\roles_service\roles_service_interface;
use App\Services\AuthService\RolesService\RolesServiceInterface;
use App\Services\PostTypeService\PostTypeServiceInterface;
use Exception;
use Illuminate\Http\Request;

class PostTypesController extends Controller
{
    private PostTypeServiceInterface $_postTypeService;
    private RolesServiceInterface $_rolesService;
    public function __construct(PostTypeServiceInterface $_postTypeService, 
    RolesServiceInterface $_rolesService){
        $this->_postTypeService = $_postTypeService;
        $this->_rolesService = $_rolesService;
    }

    public function addPostType(Request $request){
        try{
            $user = User::where(['id'=>auth()->id()])->get()->first();
            if($user!=null){
                if($this->_rolesService->isUserInRole($user, 'ADMIN')){
                    return $this->_postTypeService->addPostType($request);
                }
                return response()->json(Response::_403_forbidden_());
            }
            return response()->json(Response::_401_un_authorized_());
        }
        catch(Exception $e){
            return response()->json(Response::_500_internel_server_error_($e->getMessage()));
        }
    }

    public function updatePostType(Request $request){
        try{
            $user = User::where(['id'=>auth()->id()])->get()->first();
            if($user!=null){
                if($this->_rolesService->isUserInRole($user, 'ADMIN')){
                    return $this->_postTypeService->updatePostType($request);
                }
                return response()->json(Response::_403_forbidden_());
            }
            return response()->json(Response::_401_un_authorized_());
        }
        catch(Exception $e){
            return response()->json(Response::_500_internel_server_error_($e->getMessage()));
        }
    }

    public function findById($id){
        try{
            return $this->_postTypeService->findPostType($id);
        }
        catch(Exception $e){
            return response()->json(Response::_500_internel_server_error_($e->getMessage()));
        }
    }

    public function deleteById($id){
        try{
            $user = User::where(['id'=>auth()->id()])->get()->first();
            if($user!=null){
                if($this->_rolesService->isUserInRole($user, 'ADMIN')){
                    return $this->_postTypeService->deletePostType($id);
                }
                return response()->json(Response::_403_forbidden_());
            }
            return response()->json(Response::_401_un_authorized_());
        }
        catch(Exception $e){
            return response()->json(Response::_500_internel_server_error_($e->getMessage()));
        }
    }

    public function all(){
        try{
            return $this->_postTypeService->all();
        }
        catch(Exception $e){
            return response()->json(Response::_500_internel_server_error_($e->getMessage()));
        }
    }

}
