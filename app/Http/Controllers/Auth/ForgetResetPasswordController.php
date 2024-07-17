<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ResponseModel\Response;
use App\Services\AuthService\ForgetResetPasswordService\ForgetResetPasswordServiceInterface;
use Exception;
use Illuminate\Http\Request;

class ForgetResetPasswordController extends Controller
{
    private ForgetResetPasswordServiceInterface $_forget_reset_password_service_interface;

    public function __construct(ForgetResetPasswordServiceInterface $_forget_reset_password_service_interface){
        $this->_forget_reset_password_service_interface = $_forget_reset_password_service_interface;
    }

    public function forget_password(){
        try{
            $user = auth()->user();
            if($user==null){
                return response()->json(
                    Response::_401_un_authorized_()
                ); 
            }
            return $this->_forget_reset_password_service_interface
                ->generate_and_send_reset_password_code($user);
        }
        catch(Exception $e){
            return response()->json(
                Response::_500_internel_server_error_($e->getMessage())
            );   
        }
    }

    public function forget_password_by_email(Request $request){
        try{
            return $this->_forget_reset_password_service_interface
                ->generate_and_send_reset_password_code_by_email($request);
        }
        catch(Exception $e){
            return response()->json(
                Response::_500_internel_server_error_($e->getMessage())
            );   
        }
    }

    public function reset_password(Request $request){
        try{
            return $this->_forget_reset_password_service_interface->reset_password($request);
        }
        catch(Exception $e){
            return response()->json(
                Response::_500_internel_server_error_($e->getMessage())
            );   
        }
    }
}
