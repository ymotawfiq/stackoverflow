<?php

namespace App\Services\AuthService\RegisterUserService;

use App\Classes\CheckValidation;
use App\Classes\GenericUser;
use App\Models\ResponseModel\Response;
use App\Models\User;
use App\Services\AuthService\RolesService\RolesServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class RegisterUserService implements RegisterUserServiceInterface
{
    private RolesServiceInterface $_rolesService;
    public function __construct(RolesServiceInterface $_rolesService){
        $this->_rolesService = $_rolesService;
    }
    
    public  function register(Request $request) : JsonResponse{
        $validate_request = $this->validate_register_request($request);
        if($validate_request['is_success']){
            DB::beginTransaction();
            $user = $this->create_user($request);
            $user_role = $this->_rolesService->assignRolesToUser($user, ['USER']);
            if(!$user_role->getData()->is_success){
                DB::rollBack();
                return $user_role;
            }
            $user->sendEmailVerificationNotification();
            DB::commit();
            return response()->json(
                Response::_201_created_(
                    'user created successfully and verification link sent to you',[
                    'user'=> $user, 'roles'=> $this->_rolesService
                        ->getUserRolesNames($user)
                    ])
            );
        }
        return response()->json($validate_request);
    }
    
    public function getCurrentUser() : JsonResponse{
        $user = auth()->user();
        if($user!=null){
            return response()->json(
                Response::_200_success_('user found successfully', ['user'=>$user])
            );
        }
        return response()->json(
            Response::_204_no_content_('no users found')
        );
    }
    public function getUser(Request $request) : JsonResponse{
        $validator = $this->validate_get_user($request);
        if($validator['is_success']){
            $user = GenericUser::get_user_by_id_or_email_or_user_name(
                $request->id_or_user_name_or_email);
            if($user===null){
                return response()->json(Response::_404_not_found_('user not found'));
            }
            return response()->json(
                Response::_200_success_('user found successfully', [
                    'user' => [
                        'id'=>$user->id,
                        'display_name'=>$user->display_name,
                        'about_me'=>$user->about_me,
                        'website_url'=>$user->website_url
                    ]
                ])
            );        
        }
        return response()->json($validator);
    }

    private function validate_get_user(Request $request){
        $validator = Validator::make($request->all(), [
            'id_or_user_name_or_email'=>'required'
        ]);
        return CheckValidation::check_validation($validator);
    }

    private function validate_register_request(Request $request) : array{
        $validator = Validator::make($request->all(), [
            'email'=>['required', 'unique:users', 'email', 'string'],
            'password'=>['required', 'max:30', 'min:8'],
            'user_name'=>['required', 'unique:users', 'string'],
            'display_name'=>['required', 'string'],
            'about_me'=>['nullable'],
            'location'=>['nullable'],
            'website_url'=>['nullable'],
        ]);
        if($validator->fails()){
            return Response::_400_bad_request_('bad request',
                ['errors'=>$validator->errors()]);
        }
        return Response::_200_success_('success', $validator->validated());   
    }

    private function create_user($request) : User {
        return User::create([
            'id'=>Uuid::uuid4()->toString(),
            'email'=>$request->email,
            'normalized_email'=>strtoupper($request->email),
            'user_name'=>$request->user_name,
            'normalized_user_name'=>strtoupper($request->user_name),
            'password'=>Hash::make($request->password),
            'about_me'=>$request->about_me,
            'location'=>$request->location,
            'website_url'=>$request->website_url,
            'display_name'=>$request->display_name,
            'email_verified_at'=>now(),
            'last_access_date'=>now()
        ]);
    }

}
