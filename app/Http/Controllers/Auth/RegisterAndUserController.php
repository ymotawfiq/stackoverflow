<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ResponseModel\Response;
use App\Services\auth_service\register_user_service\register_user_service_interface;
use App\Services\AuthService\RegisterUserService\RegisterUserServiceInterface;
use Exception;
use Illuminate\Http\Request;

class RegisterAndUserController extends Controller
{
    private RegisterUserServiceInterface $_register_user_service_interface;

    public function __construct(RegisterUserServiceInterface $_register_user_service_interface,){
        $this->_register_user_service_interface = $_register_user_service_interface;
    }
    public function register(Request $request){
        try{
            return $this->_register_user_service_interface->register($request);
        }
        catch(Exception $e){
            return response()->json(
                Response::_500_internel_server_error_($e->getMessage())
            );   
        }
    }

    public function get_user(Request $request){
        try{
            return $this->_register_user_service_interface->get_user($request);
        }
        catch(Exception $e){
            return response()->json(
                Response::_500_internel_server_error_($e->getMessage())
            );   
        }
    }

    public function get_current_user(){
        try{
            return $this->_register_user_service_interface->get_current_user();
        }
        catch(Exception $e){
            return response()->json(
                Response::_500_internel_server_error_($e->getMessage())
            );   
        }
    }

}
