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
    private PostTypeServiceInterface $_post_type_service_interface;
    private RolesServiceInterface $_roles_service_interface;
    public function __construct(PostTypeServiceInterface $_post_type_service_interface, 
    RolesServiceInterface $_roles_service_interface){
        $this->_post_type_service_interface = $_post_type_service_interface;
        $this->_roles_service_interface = $_roles_service_interface;
    }

    public function add_post_type(Request $request){
        try{
            $user = User::where(['id'=>auth()->id()])->get()->first();
            if($user!=null){
                if($this->_roles_service_interface->is_user_in_role($user, 'ADMIN')){
                    return $this->_post_type_service_interface->add_post_type($request);
                }
                return response()->json(Response::_403_forbidden_());
            }
            return response()->json(Response::_401_un_authorized_());
        }
        catch(Exception $e){
            return response()->json(Response::_500_internel_server_error_($e->getMessage()));
        }
    }

    public function update_post_type(Request $request){
        try{
            $user = User::where(['id'=>auth()->id()])->get()->first();
            if($user!=null){
                if($this->_roles_service_interface->is_user_in_role($user, 'ADMIN')){
                    return $this->_post_type_service_interface->update_post_type($request);
                }
                return response()->json(Response::_403_forbidden_());
            }
            return response()->json(Response::_401_un_authorized_());
        }
        catch(Exception $e){
            return response()->json(Response::_500_internel_server_error_($e->getMessage()));
        }
    }

    public function find_post_type_by_id($id){
        try{
            return $this->_post_type_service_interface->find_post_type($id);
        }
        catch(Exception $e){
            return response()->json(Response::_500_internel_server_error_($e->getMessage()));
        }
    }

    public function delete_post_type_by_id($id){
        try{
            $user = User::where(['id'=>auth()->id()])->get()->first();
            if($user!=null){
                if($this->_roles_service_interface->is_user_in_role($user, 'ADMIN')){
                    return $this->_post_type_service_interface->delete_post_type($id);
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
            return $this->_post_type_service_interface->all();
        }
        catch(Exception $e){
            return response()->json(Response::_500_internel_server_error_($e->getMessage()));
        }
    }

}
