<?php

namespace App\Http\Controllers;

use App\Models\ResponseModel\Response;
use App\Models\User;
use App\Services\PostsListsService\PostListServiceInterface;
use Exception;
use Illuminate\Http\Request;

class PostsListsController extends Controller
{
    private PostListServiceInterface $_postListServiceInterface;
    public function __construct(PostListServiceInterface $_postListServiceInterface){
        $this->_postListServiceInterface = $_postListServiceInterface;  
    }
    public function create(Request $request){
        try{
            $user = User::where("id", auth()->id())->get()->first();
            if($user!=null){
                return $this->_postListServiceInterface->create($request, $user);
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

    public function update(Request $request){
        try{
            $user = User::where("id", auth()->id())->get()->first();
            if($user!=null){
                return $this->_postListServiceInterface->update($request, $user);
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

    public function find_by_id($list_id){
        try{
            $user = User::where("id", auth()->id())->get()->first();
            if($user!=null){
                return $this->_postListServiceInterface->find_by_id($list_id, $user);
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

    public function delete_by_id($list_id){
        try{
            $user = User::where("id", auth()->id())->get()->first();
            if($user!=null){
                return $this->_postListServiceInterface->delete_by_id($list_id, $user);
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

    public function user_lists(){
        try{
            $user = User::where("id", auth()->id())->get()->first();
            if($user!=null){
                return $this->_postListServiceInterface->user_lists($user);
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
