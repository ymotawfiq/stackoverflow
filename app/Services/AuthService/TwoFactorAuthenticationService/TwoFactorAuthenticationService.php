<?php

namespace App\Services\AuthService\TwoFactorAuthenticationService;

use App\Models\ResponseModel\Response;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class TwoFactorAuthenticationService implements TwoFactorAuthenticationServiceInterface
{

    public function enable_two_factor_authentication($user) : JsonResponse{
        if($user->is_two_factor_enabled){
            return response()->json(
                Response::_400_bad_request_('two factor authentication already enabled')
            );
        }
        User::where(['id'=>$user->id])
            ->update(['is_two_factor_enabled'=> 1]);
        return response()->json(Response::_200_success_('two factor authentication enabled successfully'));
    }

    public function un_enable_two_factor_authentication($user) : JsonResponse{
        if($user->is_two_factor_enabled){
            User::where(['id'=>$user->id])
                ->update(['is_two_factor_enabled'=> 0]);
            return response()->json(
                Response::_200_success_('two factor authentication disabled successfully')
            );
        }
        return response()->json(
            Response::_400_bad_request_('two factor authentication already disabled')
        );
    }
}
