<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ResponseModel\Response;
use App\Services\auth_service\two_factor_authentication_service\two_factor_authentication_service_interface;
use App\Services\AuthService\TwoFactorAuthenticationService\TwoFactorAuthenticationServiceInterface;
use Exception;
use Illuminate\Http\Request;

class TwoFactorAuthenticatonController extends Controller
{
    private TwoFactorAuthenticationServiceInterface $_twofactor_authentication_service_interface;
    public function __construct(TwoFactorAuthenticationServiceInterface $_twofactor_authentication_service_interface){
        $this->_twofactor_authentication_service_interface = $_twofactor_authentication_service_interface;
    }
    public function enable_two_factor_authentication(){
        try{
            $user = auth()->user();
            if($user!=null){
                return $this->_twofactor_authentication_service_interface
                    ->enable_two_factor_authentication($user);
            }
            return response()->json(
                Response::_401_un_authorized_()
            );              
        }
        catch(Exception $e){
            return response()->json(
                Response::_500_internel_server_error_($e->getMessage())
            );   
        }
    }

    public function un_enable_two_factor_authentication(){
        try{
            $user = auth()->user();
            if($user!=null){
                return $this->_twofactor_authentication_service_interface
                    ->un_enable_two_factor_authentication($user);
            }
            return response()->json(
                Response::_401_un_authorized_()
            );              
        }
        catch(Exception $e){
            return response()->json(
                Response::_500_internel_server_error_($e->getMessage())
            );   
        }
    }
}
