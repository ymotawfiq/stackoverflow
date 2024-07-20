<?php

namespace App\Http\Controllers;

use App\Models\ResponseModel\Response;
use App\Models\User;
use App\Services\PostsListsService\PostListServiceInterface;
use Exception;
use Illuminate\Http\Request;

class PostsListsController extends Controller
{
    private PostListServiceInterface $_postListService;
    public function __construct(PostListServiceInterface $_postListService){
        $this->_postListService = $_postListService;  
    }
    public function create(Request $request){
        try{
            $user = User::where("id", auth()->id())->get()->first();
            if($user!=null){
                return $this->_postListService->create($request, $user);
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
                return $this->_postListService->update($request, $user);
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

    public function findById($list_id){
        try{
            $user = User::where("id", auth()->id())->get()->first();
            if($user!=null){
                return $this->_postListService->findById($list_id, $user);
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

    public function deleteById($list_id){
        try{
            $user = User::where("id", auth()->id())->get()->first();
            if($user!=null){
                return $this->_postListService->deleteById($list_id, $user);
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

    public function userLists(){
        try{
            $user = User::where("id", auth()->id())->get()->first();
            if($user!=null){
                return $this->_postListService->userLists($user);
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
