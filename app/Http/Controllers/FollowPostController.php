<?php

namespace App\Http\Controllers;

use App\Models\ResponseModel\Response;
use App\Models\User;
use App\Services\FollwPostService\FollowPostServiceInterface;
use Exception;
use Illuminate\Http\Request;

class FollowPostController extends Controller
{
    private FollowPostServiceInterface $_followPostServiceInterface;
    public function __construct(FollowPostServiceInterface $_followPostServiceInterface){
        $this->_followPostServiceInterface = $_followPostServiceInterface;
    }
    public function follow_post($post_id){
        try{
            $user = User::where(['id'=>auth()->id()])->get()->first();
            if($user!=null){
                return $this->_followPostServiceInterface->follow_post($post_id, $user);
            }
            return response()->json(
                Response::_401_un_authorized_()
            );
        }
        catch(Exception $e){
            return response()->json(
                Response::_500_internel_server_error_($e->getMessage())
            );
        }
    }

    public function un_follow_post($post_id){
        try{
            $user = User::where(['id'=>auth()->id()])->get()->first();
            if($user!=null){
                return $this->_followPostServiceInterface->un_follow_post($post_id, $user);
            }
            return response()->json(
                Response::_401_un_authorized_()
            );
        }
        catch(Exception $e){
            return response()->json(
                Response::_500_internel_server_error_($e->getMessage())
            );
        }
    }

    public function is_user_following_post($post_id){
        try{
            $user = User::where(['id'=>auth()->id()])->get()->first();
            if($user!=null){
                return $this->_followPostServiceInterface
                    ->is_user_following_post($post_id, $user);
            }
            return response()->json(
                Response::_401_un_authorized_()
            );
        }
        catch(Exception $e){
            return response()->json(
                Response::_500_internel_server_error_($e->getMessage())
            );
        }
    }

    public function find_user_following_posts(){
        try{
            $user = User::where(['id'=>auth()->id()])->get()->first();
            if($user!=null){
                return $this->_followPostServiceInterface
                    ->find_user_following_posts($user->id);
            }
            return response()->json(
                Response::_401_un_authorized_()
            );
        }
        catch(Exception $e){
            return response()->json(
                Response::_500_internel_server_error_($e->getMessage())
            );
        }
    }

    public function find_post_following_users($post_id){
        try{
            return $this->_followPostServiceInterface->find_post_following_users($post_id);
        }
        catch(Exception $e){
            return response()->json(
                Response::_500_internel_server_error_($e->getMessage())
            );
        }
    }

}
