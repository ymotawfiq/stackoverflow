<?php

namespace App\Services\UserBadgeService;

use App\Classes\CheckValidation;
use App\Models\ResponseModel\Response;
use App\Models\User;
use App\Repositories\BadgeRepository\badge_repository_interface;
use App\Repositories\BadgeRepository\BadgeRepositoryInterface;
use App\Repositories\UserBadgeRepository\user_badge_repository;
use App\Repositories\UserBadgeRepository\UserBadgeRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserBadgeService implements UserBadgeServiceInterface
{
    /**
     * Create a new class instance.
     */
    private UserBadgeRepositoryInterface $_user_badge_repository;
    private BadgeRepositoryInterface $_badge_repository_interface;
    public function __construct(UserBadgeRepositoryInterface $_user_badge_repository, 
    BadgeRepositoryInterface $_badge_repository_interface)
    {
        $this->_user_badge_repository = $_user_badge_repository;
        $this->_badge_repository_interface = $_badge_repository_interface;
    }
    public function add_badge_to_user(Request $request){
        $validator = $this->validate_user_badge($request);
        if(!$validator['is_success']){
            return response()->json(
                Response::_400_bad_request_('bad request', $validator)
            );
        }
        if(!$this->check_if_input_exists($request)->getData()->is_success){
            return $this->check_if_input_exists($request);
        }
        $user_badge = $this->_user_badge_repository->is_user_has_badge([
            'user_id'=> $request->user_id,
            'badge_id'=> $request->badge_id
        ]);
        if($user_badge==null){
            $new_user_badge = $this->_user_badge_repository->create([
                'user_id'=> $request->user_id,
                'badge_id'=> $request->badge_id
            ]);
            return response()->json(
                Response::_201_created_('badge add to user successfully', $new_user_badge)
            );
        }
        return response()->json(
            Response::_403_forbidden_('user already has this badge')
        );
    }
    public function remove_badge_from_user(Request $request){
        $validator = $this->validate_user_badge($request);
        if(!$validator['is_success']){
            return response()->json(
                Response::_400_bad_request_('bad request', $validator)
            );
        }
        if(!$this->check_if_input_exists($request)->getData()->is_success){
            return $this->check_if_input_exists($request);
        }
        $user_badge = $this->_user_badge_repository->is_user_has_badge([
            'user_id'=> $request->user_id,
            'badge_id'=> $request->badge_id
        ]);
        if($user_badge!=null){
            $this->_user_badge_repository->remove_badge_from_user([
                'user_id'=> $request->user_id,
                'badge_id'=> $request->badge_id
            ]);
            return response()->json(
                Response::_204_no_content_('badge deleted from user successfully')
            );
        }
        return response()->json(
            Response::_404_not_found_('user badge not found')
        );
    }
    public function is_user_has_badge(Request $request){
        $validator = $this->validate_user_badge($request);
        if(!$validator['is_success']){
            return response()->json(
                Response::_400_bad_request_('bad request', $validator)
            );
        }
        if(!$this->check_if_input_exists($request)->getData()->is_success){
            return $this->check_if_input_exists($request);
        }
        $user_badge = $this->_user_badge_repository->is_user_has_badge([
            'user_id'=> $request->user_id,
            'badge_id'=> $request->badge_id
        ]);
        if($user_badge!=null){
            return response()->json(
                Response::_200_success_('user badge found successfully', $user_badge)
            );
        }
        return response()->json(
            Response::_404_not_found_('user badge not found')
        );
    }
    public function get_user_badges($user_id){
        $user = User::where(['id'=> $user_id])->get()->first();
        if($user==null){
            return response()->json(
                Response::_404_not_found_('user not found')
            );
        }
        $user_badges = $this->_user_badge_repository->get_user_badges($user_id);
        if($user_badges->count()==0 || empty($user_badges) || $user_badges==null){
            return response()->json(
                Response::_204_no_content_('user has no badges')
            );   
        }
        return response()->json(
            Response::_200_success_('user badges found successfully', $user_badges)
        );
    }


    private function validate_user_badge(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id'=>['required'],
            'badge_id'=>['required'],
        ]);
        return CheckValidation::check_validation($validator);
    }

    private function check_if_input_exists(Request $request){
        $user = User::where(['id'=>$request->user_id])->get()->first();
        if($user==null){
            return response()->json(
                Response::_404_not_found_('user not found')
            );
        }
        $badge = $this->_badge_repository_interface->find_by_id($request->badge_id);
        if($badge==null){
            return response()->json(
                Response::_404_not_found_('badge not found')
            );
        }
        return response()->json(
            Response::_200_success_()
        );
    }

}
