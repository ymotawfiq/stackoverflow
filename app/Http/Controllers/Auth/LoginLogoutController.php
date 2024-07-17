<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ResponseModel\Response;
use App\Models\User;
use App\Services\auth_service\login_logout_service\login_logout_service_interface;
use App\Services\auth_service\token_service\token_service_interface;
use App\Services\AuthService\LoginLogoutService\LoginLogoutServiceInterface;
use App\Services\AuthService\TokenService\TokenServiceInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginLogoutController extends Controller
{
    private LoginLogoutServiceInterface $_login_logout_service_interface;
    private TokenServiceInterface $_token_service_interface;

    public function __construct(LoginLogoutServiceInterface $_login_logout_service,
    TokenServiceInterface $_token_service_interface){
        $this->_login_logout_service_interface = $_login_logout_service;
        $this->_token_service_interface = $_token_service_interface;
    }
    public function login_by_email(Request $request){
        try{
            $response = $this->_login_logout_service_interface
            ->login_by_email($request);
            return $response;
        }
        catch(Exception $e){
            return response()->json(
                Response::_500_internel_server_error_($e->getMessage())
            );   
        }
    }

    public function login_by_user_name(Request $request){
        try{
            $response = $this->_login_logout_service_interface
            ->login_by_user_name($request);
            return $response;
        }
        catch(Exception $e){
            return response()->json(
                Response::_500_internel_server_error_($e->getMessage())
            );   
        }
    }
    public function login_by_id_user_name_or_email(Request $request){
        try{
            $response = $this->_login_logout_service_interface
            ->login_by_id_or_userName_or_email($request);
            return $response;
        }
        catch(Exception $e){
            return response()->json(
                Response::_500_internel_server_error_($e->getMessage())
            );   
        }
    }

    public function logout(){
        return $this->_login_logout_service_interface->logout();
    }

    public function login_with_2fa(Request $request){
        try{
            $validator = $this->validate_two_factor_login($request);
            if(!$validator['is_success']){
                return response()->json([$validator]);
            }
            $user = User::where(['email'=>$request->email])->get()->first();
            if($user==null){
                return response()->json(
                    Response::_400_bad_request_('invalid code or email')
                );
            }
            else if(!$user->is_two_factor_enabled){
                return response()->json(
                    Response::_400_bad_request_('two factor not enabled')
                );
            }
            if($user->two_factor_code === $request->code){
                if(now()<$user->two_factor_expires_at){
                    $this->_login_logout_service_interface->reset_2fa_code($user);
                    return response()->json(
                        Response::_200_success_('token generated successfully', [
                            'token'=>$this->_token_service_interface
                                ->generate_token($user)->getData()->data->token,
                            'type'=>'bearer token'
                        ])
                    );
                }
            }
            return response()->json(
                Response::_400_bad_request_('invalid code')
            );
        }
        catch(Exception $e){
            return response()->json(
                Response::_500_internel_server_error_($e->getMessage())
            );   
        }
    }

    private function validate_two_factor_login(Request $request){
        $validator = Validator::make($request->all(), [
            'email'=>['required','email'],
            'code'=> ['required'],
        ]);
        if($validator->fails()){
            return Response::_400_bad_request_('bad request', ['errors'=>$validator->errors()]);
        }
        return Response::_200_success_();
    }
}
