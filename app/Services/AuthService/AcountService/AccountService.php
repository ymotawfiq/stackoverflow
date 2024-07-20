<?php

namespace App\Services\AuthService\AccountService;

use App\Classes\CheckValidation;
use App\Models\ResponseModel\Response;
use App\Models\User;
use App\Services\AuthService\AccountService\AccountServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AccountService implements AccountServiceInterface
{
    public function updateAccount(Request $request, $user) : JsonResponse{
        $validator = $this->validate_update_account($request);
        if($validator['is_success']){
            User::where('id', $user->id)->update($validator['data']);
            return response()->json(Response::_200_success_('account updated successfully'));
        }
        return response()->json($validator);
    }
    public function updateDisplayName(Request $request, $user) : JsonResponse{
        $validator = $this->validate_update_display_name($request);
        if($validator['is_success']){
            User::where(['id'=>$user->id])->update([
                'display_name'=>$request->display_name
            ]);
            return response()->json(Response::_200_success_('display name updated successfully'));
        }
        return response()->json($validator);
    }
    public function updateUserName(Request $request, $user) : JsonResponse{
        $validator = $this->validate_update_user_name( $request);
        if($validator['is_success']){
            User::where(['id'=>$user->id])->update([
                'user_name'=>$request->user_name
            ]);
            return response()->json(Response::_200_success_('user name updated successfully'));
        }
        return response()->json($validator);
    }

    private function validate_update_user_name(Request $request) : array{
        $validator = Validator::make($request->all(), [
            'user_name'=>['required', 'unique:users']
        ]);
        return CheckValidation::check_validation($validator);    
    }


    private function validate_update_display_name(Request $request){
        $validator = Validator::make($request->all(), [
            'display_name'=>['required']
        ]);
        return CheckValidation::check_validation($validator);
    }

    private function validate_update_account(Request $request) {
        $validator = Validator::make($request->all(),[
            'about_me'=>['nullable'],
            'website_url'=>'nullable',
            'location'=>'nullable',
        ]);
        if($validator->fails()){
            return Response::_400_bad_request_('bad request', ['errors'=>$validator->errors()]);
        }
        return Response::_200_success_('success', $validator->validated());
    }
}
