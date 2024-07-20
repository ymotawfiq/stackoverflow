<?php

namespace App\Services\AuthService\EmailService;

use App\Classes\CheckValidation;
use App\Classes\GenericUser;
use App\Models\ResponseModel\Response;
use App\Services\AuthService\EmailService\EmailServiceInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class EmailService implements EmailServiceInterface
{
    public function resendEmailVerificationLink(Request $request) : JsonResponse{
        $validator = $this->validate_resend_email_verification_link($request);
        if($validator['is_success']){
            
            $user = GenericUser::get_user_by_id_or_email_or_user_name($request->id_user_name_email);
            if($user!=null){
                if($user->is_email_verified){
                    return response()->json(Response::_403_forbidden_('Email already verified'));
                }
                $user->sendEmailVerificationNotification();
            }
            return response()->json(Response::_200_success_('check your inbox'));
        }
        return response()->json($validator);
    }

    private function validate_resend_email_verification_link(Request $request){
        $validator = Validator::make($request->all(), [
            'id_user_name_email'=>['required']
        ]);
        return CheckValidation::check_validation($validator);
    }
}
