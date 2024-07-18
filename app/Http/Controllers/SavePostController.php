<?php

namespace App\Http\Controllers;

use App\Models\ResponseModel\Response;
use App\Models\User;
use App\Services\SavePostService\SavePostServiceInterface;
use Exception;
use Illuminate\Http\Request;

class SavePostController extends Controller
{
    private SavePostServiceInterface $_savePostServiceInterface;
    public function __construct(SavePostServiceInterface $_savePostServiceInterface){
        $this->_savePostServiceInterface = $_savePostServiceInterface;
    }
    public function save_post(Request $request){
        try{
            $user = User::where(['id'=>auth()->id()])->get()->first();
            if($user!=null){
                return $this->_savePostServiceInterface->savePost($request, $user);
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

    public function us_save_post($id){
        try{
            $user = User::where(['id'=>auth()->id()])->get()->first();
            if($user!=null){
                return $this->_savePostServiceInterface->unSavePost($id, $user);
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
    public function find_saved_post_by_id($id){
        try{
            $user = User::where(['id'=>auth()->id()])->get()->first();
            if($user!=null){
                return $this->_savePostServiceInterface->getUserSavedPostById($id, $user);
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

    public function find_user_saved_posts(){
        try{
            $user = User::where(['id'=>auth()->id()])->get()->first();
            if($user!=null){
                return $this->_savePostServiceInterface->getUserSavedPosts($user);
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

    public function find_user_saved_posts_by_list_id($list_id){
        try{
            $user = User::where(['id'=>auth()->id()])->get()->first();
            if($user!=null){
                return $this->_savePostServiceInterface
                    ->getUserSavedPostsByListId($list_id, $user);
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
}
