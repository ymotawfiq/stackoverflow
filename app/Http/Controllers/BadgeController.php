<?php

namespace App\Http\Controllers;

use App\Models\ResponseModel\Response;
use App\Models\User;
use App\Services\auth_service\roles_service\roles_service_interface;
use App\Services\BadgeService\badge_service_interface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BadgeController extends Controller
{
    private badge_service_interface $_badge_service_interface;
    private roles_service_interface $_roles_service_interface;
    public function __construct(badge_service_interface $_badge_service_interface, 
    roles_service_interface $_roles_service_interface){
        $this->_badge_service_interface = $_badge_service_interface;
        $this->_roles_service_interface = $_roles_service_interface;
    }

    public function create(Request $request){
        try{
            $user = User::where(['id'=>auth()->id()])->get()->first();
            if($user!=null){
                if($this->_roles_service_interface->is_user_in_role($user, 'ADMIN')){
                    return $this->_badge_service_interface->create($request);
                }
                return response()->json(Response::_403_forbidden_());
            }
            return response()->json(Response::_401_un_authorized_());
        }
        catch(Exception $e){
            return response()->json(
                Response::_500_internel_server_error_($e->getMessage())
            );
        }
    }

    public function update(Request $request){
        try{
            $user = User::where(['id'=>auth()->id()])->get()->first();
            if($user!=null){
                if($this->_roles_service_interface->is_user_in_role($user, 'ADMIN')){
                    return $this->_badge_service_interface->update($request);
                }
                return response()->json(Response::_403_forbidden_());
            }
            return response()->json(Response::_401_un_authorized_());
        }
        catch(Exception $e){
            return response()->json(
                Response::_500_internel_server_error_($e->getMessage())
            );
        }
    }

    public function delete_by_id($id){
        try{
            $user = User::where(['id'=>auth()->id()])->get()->first();
            if($user!=null){
                if($this->_roles_service_interface->is_user_in_role($user, 'ADMIN')){
                    return $this->_badge_service_interface->delete_by_id($id);
                }
                return response()->json(Response::_403_forbidden_());
            }
            return response()->json(Response::_401_un_authorized_());
        }
        catch(Exception $e){
            return response()->json(
                Response::_500_internel_server_error_($e->getMessage())
            );
        }
    }

    public function find_by_id($id){
        try{
            return $this->_badge_service_interface->find_by_id($id);
        }
        catch(Exception $e){
            return response()->json(
                Response::_500_internel_server_error_($e->getMessage())
            );
        }
    }

    public function all(){
        try{
            return $this->_badge_service_interface->all();
        }
        catch(Exception $e){
            return response()->json(
                Response::_500_internel_server_error_($e->getMessage())
            );
        }
    }

}
