<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ResponseModel\Response;
use App\Services\AuthService\ForgetResetPasswordService\ForgetResetPasswordServiceInterface;
use Exception;
use Illuminate\Http\Request;

class ForgetResetPasswordController extends Controller
{
    private ForgetResetPasswordServiceInterface $_forgetResetPasswordService;

    public function __construct(ForgetResetPasswordServiceInterface $_forgetResetPasswordService){
        $this->_forgetResetPasswordService = $_forgetResetPasswordService;
    }

    public function forgetPassword(){
        try{
            $user = auth()->user();
            if($user==null){
                return response()->json(
                    Response::_401_un_authorized_()
                ); 
            }
            return $this->_forgetResetPasswordService
                ->generateAndSendResetPasswordCode($user);
        }
        catch(Exception $e){
            return response()->json(
                Response::_500_internel_server_error_($e->getMessage())
            );   
        }
    }

    public function forgetPasswordByEmail(Request $request){
        try{
            return $this->_forgetResetPasswordService
                ->generateAndSendResetPasswordCodeByEmail($request);
        }
        catch(Exception $e){
            return response()->json(
                Response::_500_internel_server_error_($e->getMessage())
            );   
        }
    }

    public function resetPassword(Request $request){
        try{
            return $this->_forgetResetPasswordService->resetPassword($request);
        }
        catch(Exception $e){
            return response()->json(
                Response::_500_internel_server_error_($e->getMessage())
            );   
        }
    }
}
