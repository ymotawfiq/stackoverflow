<?php

namespace App\Services\AuthService\ForgetResetPasswordService;

use App\Classes\CheckValidation;
use App\Mail\SendCodeResetPassword;
use App\Models\ResponseModel\Response;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class ForgetResetPasswordService implements ForgetResetPasswordServiceInterface
{
    public function generate_and_send_reset_password_code($user) : JsonResponse{
        $code = Uuid::uuid4()->toString(); 
        $is_code_sent = DB::table('password_reset_tokens')
            ->where(['email'=>$user->email])->get()->first();
        if($is_code_sent!=null){
            if(now()<$is_code_sent->created_at){
                return response()->json(
                    Response::_400_bad_request_('code already sent check your inbox')
                );
            }
            $this->reset_password_code($user);
            return $this->send_reset_password_code($user, $code);
        }
        return $this->send_reset_password_code($user,$code);
    }

    public function generate_and_send_reset_password_code_by_email(Request $request) : JsonResponse{
        $validator = $this->validate_forget_password($request);
        if($validator['is_success']){
            $user = User::where('email',$request->email)->get()->first();
            return $this->generate_and_send_reset_password_code($user);
        }
        return response()->json($validator);
    }
    public function reset_password_code($user){
        DB::table('password_reset_tokens')->where(['email'=>$user->email])->delete();
    }
    public function reset_password(Request $request) : JsonResponse{
        $validator = $this->validate_reset_password_request( $request );
        if(!$validator['is_success']){
            return response()->json($validator);
        }
        $user = User::where('email',$request->email)->get()->first();
        if($user==null){
            return response()->json(
                Response::_400_bad_request_('invalid email or code')
            );
        }
        $code = DB::table('password_reset_tokens')
        ->where(['email'=>$request->email])->get()->first();
        if($code!=null){
            if($code->token === $request->code){
                if(now()<$code->created_at){
                    User::where('id',$user->id)->update([
                        'password'=>Hash::make($request->password),
                    ]);
                    $this->reset_password_code($user);
                    return response()->json(Response::_200_success_('password reset successfully'));
                }
            }
        }
        return response()->json(Response::_400_bad_request_('invalid email or code'));
    }
    private function send_reset_password_code($user, $code) : JsonResponse{
        DB::table('password_reset_tokens')->insert([
            'created_at'=>now()->addMinutes(10),
            'token'=>$code,
            'email'=>$user->email
        ]);
        Mail::to($user->email)->send(new SendCodeResetPassword($code));
        return response()->json(Response::_200_success_('code already sent check your inbox'));
    }

    private function validate_forget_password(Request $request){
        $validator = Validator::make($request->all(), [
            'email'=>['required']
        ]);
        return CheckValidation::check_validation($validator);    
    }

    private function validate_reset_password_request(Request $request){
        $validator = Validator::make($request->all(), [
            'email'=>['required', 'email'],
            'code'=>['required'],
            'password'=>['required', 'min:8', 'max:30']
        ]);
        return CheckValidation::check_validation($validator);
    }
}
