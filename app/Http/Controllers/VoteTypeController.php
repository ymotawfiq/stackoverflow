<?php

namespace App\Http\Controllers;

use App\Models\ResponseModel\Response;
use App\Models\User;
use App\Services\AuthService\RolesService\RolesServiceInterface;
use App\Services\VoteTypeService\VoteTypeServiceInterface;
use Exception;
use Illuminate\Http\Request;

class VoteTypeController extends Controller
{
    private VoteTypeServiceInterface $_vote_type_service_interface;
    private RolesServiceInterface $_roles_service_interface;
    public function __construct(VoteTypeServiceInterface $_vote_type_service_interface, 
    RolesServiceInterface $_roles_service_interface){
        $this->_vote_type_service_interface = $_vote_type_service_interface;
        $this->_roles_service_interface = $_roles_service_interface;
    }

    public function add_vote_type(Request $request){
        try{
            $user = User::where(['id'=>auth()->id()])->get()->first();
            if($user!=null){
                if($this->_roles_service_interface->is_user_in_role($user, 'ADMIN')){
                    return $this->_vote_type_service_interface->add_vote_type($request);
                }
                return response()->json(Response::_403_forbidden_());
            }
            return response()->json(Response::_401_un_authorized_());
        }
        catch(Exception $e){
            return response()->json(Response::_500_internel_server_error_($e->getMessage()));
        }
    }

    public function update_vote_type(Request $request){
        try{
            $user = User::where(['id'=>auth()->id()])->get()->first();
            if($user!=null){
                if($this->_roles_service_interface->is_user_in_role($user, 'ADMIN')){
                    return $this->_vote_type_service_interface->update_vote_type($request);
                }
                return response()->json(Response::_403_forbidden_());
            }
            return response()->json(Response::_401_un_authorized_());
        }
        catch(Exception $e){
            return response()->json(Response::_500_internel_server_error_($e->getMessage()));
        }
    }

    public function find_vote_type_by_id($id){
        try{
            return $this->_vote_type_service_interface->find_by_id($id);
        }
        catch(Exception $e){
            return response()->json(Response::_500_internel_server_error_($e->getMessage()));
        }
    }

    public function delete_vote_type_by_id($id){
        try{
            $user = User::where(['id'=>auth()->id()])->get()->first();
            if($user!=null){
                if($this->_roles_service_interface->is_user_in_role($user, 'ADMIN')){
                    return $this->_vote_type_service_interface->delete_by_id($id);
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
            return $this->_vote_type_service_interface->all_vote_types();
        }
        catch(Exception $e){
            return response()->json(Response::_500_internel_server_error_($e->getMessage()));
        }
    }
}
