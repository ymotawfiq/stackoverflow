<?php

namespace App\Services\AuthService\LoginLogoutService;

use App\Classes\GenericUser;
use App\Mail\SendTwoFactorCode;
use App\Models\ResponseModel\Response;
use App\Services\AuthService\TokenService\TokenServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class LoginLogoutService implements LoginLogoutServiceInterface
{
    private TokenServiceInterface $_tokenService;
    public function __construct(TokenServiceInterface $_tokenService){
        $this->_tokenService = $_tokenService;
    }
    
    public  function loginByEmail(Request $request) : JsonResponse{
        $validator = $this->validate_login_by_email_request($request);
        if(!$validator['is_success']){
            return response()->json($validator);
        }
        $user = GenericUser::get_user_by_id_or_email_or_user_name(
            $request->email);
        if($user==null){
            return response()->json(
                Response::_400_bad_request_('invalid username or password')
            );
        }
        if($user->is_two_factor_enabled){
            if($this->_tokenService
                ->generateTokenForNon2FAUser($user, $request)->getData()->is_success){
                $this->generate_and_send_two_factor_code($user);
                return response()->json(
                    Response::_200_success_('two factor code sent to your email')
                );
            }
            return response()->json(
                Response::_400_bad_request_('invalid username or password')
            );
        }
        return $this->_tokenService->generateTokenForNon2FAUser($user, $request); 
    }
    public  function loginByUserName(Request $request) : JsonResponse{
        $validator = $this->validate_login_by_user_name_request($request);
        if(!$validator['is_success']){
            return response()->json($validator);
        }
        $user = GenericUser::get_user_by_id_or_email_or_user_name(
            $request->user_name);
        if($user==null){
            return response()->json(
                Response::_400_bad_request_('invalid username or password')
            );
        }
        if($user->is_two_factor_enabled){
            if($this->_tokenService->generateTokenForNon2FAUser($user, $request)
                ->getData()->is_success){
                    $this->generate_and_send_two_factor_code($user);
                    return response()->json(
                        Response::_200_success_('two factor code sent to your email')
                    );
            }
            return response()->json(
                Response::_400_bad_request_('invalid username or password')
            );
        }
        return $this->_tokenService->generateTokenForNon2FAUser($user, $request);  
    }
    public  function loginByIdOrUserNameOrEmail(Request $request) : JsonResponse{
        $validator = $this->validate_login_by_id_or_userName_or_email($request);
        if(!$validator['is_success']){
            return response()->json($validator);
        }
        $user = GenericUser::get_user_by_id_or_email_or_user_name(
            $request->id_user_name_email);
        if($user==null){
            return response()->json(
                Response::_400_bad_request_('invalid username or password')
            );
        }
        if($user->is_two_factor_enabled){
            if($this->_tokenService->generateTokenForNon2FAUser($user, $request)
                ->getData()->is_success){
                    $this->generate_and_send_two_factor_code($user);
                    return response()->json([
                        Response::_200_success_('two factor code sent to your email')
                    ]);
            }
            return response()->json(
                Response::_400_bad_request_('invalid username or password')
            );
        }
        return $this->_tokenService->generateTokenForNon2FAUser($user, $request);
    }
    public function logout() : JsonResponse{
        auth()->logout();
        return response()->json(
            Response::_200_success_('logged out successfully')
        );
    }

    public function reset2FACode($user){
        DB::table('users')->where('id', $user->id)->update([
            'two_factor_expires_at'=>null,
            'two_factor_code'=>null
        ]);
    }

    private function validate_login_by_email_request(Request $request) : array{
        $validator = Validator::make($request->all(), [
            'email'=>['required', 'email'],
            'password'=>['required']
        ]);
        if($validator->fails()){
            return Response::_400_bad_request_('bad request',
                ['errors'=>$validator->errors()]);
        }
        return Response::_200_success_('success', $validator->validated());
    }

    private function validate_login_by_user_name_request(Request $request) : array{
        $validator = Validator::make($request->all(), [
            'user_name'=>['required'],
            'password'=>['required']
        ]);
        if($validator->fails()){
            return Response::_400_bad_request_('bad request',
                ['errors'=>$validator->errors()]);
        }
        return Response::_200_success_('success', $validator->validated());
    }

    private function validate_login_by_id_or_userName_or_email(Request $request) : array{
        $validator = Validator::make($request->all(), [
            'id_user_name_email'=>['required'],
            'password'=>['required']
        ]);
        if($validator->fails()){
            return Response::_400_bad_request_('bad request',
                ['errors'=>$validator->errors()]);
        }
        return Response::_200_success_('success', $validator->validated());
    }

    private function generate_and_send_two_factor_code($user){
        $this->reset2FACode($user);
        $code = Uuid::uuid4()->toString(); 
        DB::table('users')->where('id', $user->id)->update([
            'two_factor_expires_at'=>now()->addMinutes(10),
            'two_factor_code'=>$code
        ]);
        Mail::to($user->email)->send(new SendTwoFactorCode($code));
    }


}
