<?php

namespace App\Http\Controllers;

use App\Models\ResponseModel\Response;
use App\Models\User;
use App\Services\auth_service\roles_service\roles_service_interface;
use App\Services\UserBadgeService\user_badge_service_interface;
use Exception;
use Illuminate\Http\Request;

class UserBadgesController extends Controller
{
    private user_badge_service_interface $_user_badge_service_interface;
    private roles_service_interface $_roles_service_interface;
    public function __construct(user_badge_service_interface $_user_badge_service_interface, 
    roles_service_interface $_roles_service_interface){
        $this->_user_badge_service_interface = $_user_badge_service_interface;
        $this->_roles_service_interface = $_roles_service_interface;
    }

    public function add_badge_to_user(Request $request){
        try{
            try{
                $user = User::where(['id'=>auth()->id()])->get()->first();
                if($user!=null){
                    if($this->_roles_service_interface->is_user_in_role($user, 'ADMIN')){
                        return $this->_user_badge_service_interface->add_badge_to_user($request);
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
        catch(Exception $e){
            return response()->json(
                Response::_500_internel_server_error_($e->getMessage())
            );
        }
    }

    public function is_user_has_badge(Request $request){
        try{
            try{
                $user = User::where(['id'=>auth()->id()])->get()->first();
                if($user!=null){
                    if($this->_roles_service_interface->is_user_in_role($user, 'ADMIN')){
                        return $this->_user_badge_service_interface->is_user_has_badge($request);
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
        catch(Exception $e){
            return response()->json(
                Response::_500_internel_server_error_($e->getMessage())
            );
        }
    }

    public function remove_badge_from_user(Request $request){
        try{
            try{
                $user = User::where(['id'=>auth()->id()])->get()->first();
                if($user!=null){
                    if($this->_roles_service_interface->is_user_in_role($user, 'ADMIN')){
                        return $this->_user_badge_service_interface->remove_badge_from_user($request);
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
        catch(Exception $e){
            return response()->json(
                Response::_500_internel_server_error_($e->getMessage())
            );
        }
    }

    public function get_user_badges($user_id){
        try{
            try{
                $user = User::where(['id'=>auth()->id()])->get()->first();
                if($user!=null){
                    if($this->_roles_service_interface->is_user_in_role($user, 'ADMIN')){
                        return $this->_user_badge_service_interface->get_user_badges($user_id);
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
        catch(Exception $e){
            return response()->json(
                Response::_500_internel_server_error_($e->getMessage())
            );
        }
    }

}
