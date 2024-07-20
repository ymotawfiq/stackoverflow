<?php

namespace App\Http\Controllers;

use App\Models\ResponseModel\Response;
use App\Models\User;
use App\Services\auth_service\roles_service\roles_service_interface;
use App\Services\AuthService\RolesService\RolesServiceInterface;
use App\Services\UserBadgeService\user_badge_service_interface;
use App\Services\UserBadgeService\UserBadgeServiceInterface;
use Exception;
use Illuminate\Http\Request;

class UserBadgesController extends Controller
{
    private UserBadgeServiceInterface $_userBadgeService;
    private RolesServiceInterface $_rolesService;
    public function __construct(UserBadgeServiceInterface $_userBadgeService, 
    RolesServiceInterface $_rolesService){
        $this->_userBadgeService = $_userBadgeService;
        $this->_rolesService = $_rolesService;
    }

    public function addBadgeToUser(Request $request){
        try{
            try{
                $user = User::where(['id'=>auth()->id()])->get()->first();
                if($user!=null){
                    if($this->_rolesService->isUserInRole($user, 'ADMIN')){
                        return $this->_userBadgeService->addBadgeToUser($request);
                    }
                    return response()->json(Response::_403_forbidden_());
                }
                return response()->json(Response::_401_un_authorized_());
            }
            catch(Exception $e){
                return response()->json(
                    Response::_500_internel_server_error_($e->getMessage())
                );
            }
        }
        catch(Exception $e){
            return response()->json(
                Response::_500_internel_server_error_($e->getMessage())
            );
        }
    }

    public function isUserHasBadge(Request $request){
        try{
            try{
                $user = User::where(['id'=>auth()->id()])->get()->first();
                if($user!=null){
                    if($this->_rolesService->isUserInRole($user, 'ADMIN')){
                        return $this->_userBadgeService->isUserHasBadge($request);
                    }
                    return response()->json(Response::_403_forbidden_());
                }
                return response()->json(Response::_401_un_authorized_());
            }
            catch(Exception $e){
                return response()->json(
                    Response::_500_internel_server_error_($e->getMessage())
                );
            }
        }
        catch(Exception $e){
            return response()->json(
                Response::_500_internel_server_error_($e->getMessage())
            );
        }
    }

    public function removeBadgeFromUser(Request $request){
        try{
            try{
                $user = User::where(['id'=>auth()->id()])->get()->first();
                if($user!=null){
                    if($this->_rolesService->isUserInRole($user, 'ADMIN')){
                        return $this->_userBadgeService->removeBadgeFromUser($request);
                    }
                    return response()->json(Response::_403_forbidden_());
                }
                return response()->json(Response::_401_un_authorized_());
            }
            catch(Exception $e){
                return response()->json(
                    Response::_500_internel_server_error_($e->getMessage())
                );
            }
        }
        catch(Exception $e){
            return response()->json(
                Response::_500_internel_server_error_($e->getMessage())
            );
        }
    }

    public function getUserBadges($user_id){
        try{
            try{
                $user = User::where(['id'=>auth()->id()])->get()->first();
                if($user!=null){
                    if($this->_rolesService->isUserInRole($user, 'ADMIN')){
                        return $this->_userBadgeService->getUserBadges($user_id);
                    }
                    return response()->json(Response::_403_forbidden_());
                }
                return response()->json(Response::_401_un_authorized_());
            }
            catch(Exception $e){
                return response()->json(
                    Response::_500_internel_server_error_($e->getMessage())
                );
            }
        }
        catch(Exception $e){
            return response()->json(
                Response::_500_internel_server_error_($e->getMessage())
            );
        }
    }

}
