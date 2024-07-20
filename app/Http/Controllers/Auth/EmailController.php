<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ResponseModel\Response;
use App\Models\User;
use App\Services\AuthService\EmailService\EmailServiceInterface;
use Exception;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    private EmailServiceInterface $_emailService;
    public function __construct(EmailServiceInterface $_emailService){
        $this->_emailService = $_emailService;
    }


    public function verify($user_id, Request $request){
        try{
            if(!$request->hasValidSignature()){
                return response()->json(
                    Response::_401_un_authorized_('Invalid/Expired url provided')
                );
            }
            $user = User::where(['id'=>$user_id])->get()->first();
            if($user->is_email_verified){
                return response()->json(
                    Response::_400_bad_request_('Email already verified')
                );
            }
            User::where(['id'=>$user_id])->update(['is_email_verified'=>1]);
            return response()->json(
                Response::_200_success_('Email verified successfully')
            );
        }
        catch(Exception $e){
            return response()->json(
                Response::_500_internel_server_error_($e->getMessage())
            );   
        }
    }

    public function resend(Request $request){
        try{
            return $this->_emailService
                ->resendEmailVerificationLink($request);
        }
        catch(Exception $e){
            return response()->json(
                Response::_500_internel_server_error_($e->getMessage())
            );   
        }
    }
}
