<?php

namespace App\Services\AuthService\TokenService;

use App\Models\ResponseModel\Response;
use App\Services\AuthService\RolesService\RolesServiceInterface;
use Ramsey\Uuid\Uuid;
use Tymon\JWTAuth\Facades\JWTAuth;

class TokenService implements TokenServiceInterface
{
    private RolesServiceInterface $_roles_service_interface;
    public function __construct(RolesServiceInterface $_roles_service_interface){
        $this->_roles_service_interface = $_roles_service_interface;
    }
    public function generate_token($user){
        $custom_claims = [
            'email'=> $user->email,
            'jti'=>Uuid::uuid4()->toString(),
            'user_name'=>$user->user_name,
            'roles'=>$this->_roles_service_interface->get_user_roles_names($user),
            'id'=>$user->id
        ];
        $token = JWTAuth::claims($custom_claims)->fromUser($user);
        if($token){
            return response()->json(
                Response::_200_success_('token generated successfully', [
                    'token'=>$token,
                    'token type'=>'bearer token'
                ])
            );
        }
    }
    public function generate_token_non_2fa_user($user, $request){
        if(!$user->is_email_verified){
            return response()->json(Response::_400_bad_request_('please verify your email'));
        }
        $custom_claims = [
            'email'=> $user->email,
            'jti'=>Uuid::uuid4()->toString(),
            'user_name'=>$user->user_name,
            'roles'=>$this->_roles_service_interface->get_user_roles_names($user),
            'id'=>$user->id
        ];
        $token = JWTAuth::claims($custom_claims)->attempt([
                    'email'=>$user->email,
                    'password'=>$request->password
                ]);
        if($token){
            return response()->json(
                Response::_200_success_('token generated successfully', [
                    'token'=>$token,
                    'token type'=>'bearer token'
                ])
            );
        }
        return response()->json(Response::_400_bad_request_('invalid user name or password'));
    }
}
