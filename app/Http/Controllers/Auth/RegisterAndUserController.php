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
    private RegisterUserServiceInterface $_registerUserService;

    public function __construct(RegisterUserServiceInterface $_registerUserService,){
        $this->_registerUserService = $_registerUserService;
    }
    public function register(Request $request){
        try{
            return $this->_registerUserService->register($request);
        }
        catch(Exception $e){
            return response()->json(
                Response::_500_internel_server_error_($e->getMessage())
            );   
        }
    }

    public function getUser(Request $request){
        try{
            return $this->_registerUserService->getUser($request);
        }
        catch(Exception $e){
            return response()->json(
                Response::_500_internel_server_error_($e->getMessage())
            );   
        }
    }

    public function getCurrentUser(){
        try{
            return $this->_registerUserService->getCurrentUser();
        }
        catch(Exception $e){
            return response()->json(
                Response::_500_internel_server_error_($e->getMessage())
            );   
        }
    }

}
