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
    private TwoFactorAuthenticationServiceInterface $_2FAService;
    public function __construct(TwoFactorAuthenticationServiceInterface $_2FAService){
        $this->_2FAService = $_2FAService;
    }
    public function enable2FA(){
        try{
            $user = auth()->user();
            if($user!=null){
                return $this->_2FAService
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

    public function diable2FA(){
        try{
            $user = auth()->user();
            if($user!=null){
                return $this->_2FAService
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
