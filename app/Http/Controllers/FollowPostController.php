<?php

namespace App\Http\Controllers;

use App\Models\ResponseModel\Response;
use App\Models\User;
use App\Services\FollwPostService\FollowPostServiceInterface;
use Exception;
use Illuminate\Http\Request;

class FollowPostController extends Controller
{
    private FollowPostServiceInterface $_followPostService;
    public function __construct(FollowPostServiceInterface $_followPostService){
        $this->_followPostService = $_followPostService;
    }
    public function followPost($post_id){
        try{
            $user = User::where(['id'=>auth()->id()])->get()->first();
            if($user!=null){
                return $this->_followPostService->followPost($post_id, $user);
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

    public function unFollowPost($post_id){
        try{
            $user = User::where(['id'=>auth()->id()])->get()->first();
            if($user!=null){
                return $this->_followPostService->unFollowPost($post_id, $user);
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

    public function isUserFollowingPost($post_id){
        try{
            $user = User::where(['id'=>auth()->id()])->get()->first();
            if($user!=null){
                return $this->_followPostService
                    ->isUserFollowingPost($post_id, $user);
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

    public function findUserFollowingPosts(){
        try{
            $user = User::where(['id'=>auth()->id()])->get()->first();
            if($user!=null){
                return $this->_followPostService
                    ->findUserFollowingPosts($user->id);
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

    public function findPostFollowingUsers($post_id){
        try{
            return $this->_followPostService->findPostFollowingUsers($post_id);
        }
        catch(Exception $e){
            return response()->json(
                Response::_500_internel_server_error_($e->getMessage())
            );
        }
    }

}
