<?php

namespace App\Http\Controllers;

use App\Models\DTOs\UpdatePostDto;
use App\Models\ResponseModel\Response;
use App\Models\User;
use App\Services\AuthService\RolesService\RolesServiceInterface;
use App\Services\PostService\PostServiceInterface;
use Exception;
use Illuminate\Http\Request;

class PostController extends Controller
{
    private PostServiceInterface $_postService;
    public function __construct(PostServiceInterface $_postService){
        $this->_postService = $_postService;
    }

    public function addPost(Request $request){
        try{
            $user = User::where(['id'=>auth()->id()])->get()->first();
            if($user!=null){
                return $this->_postService->create($request, $user);        
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

    public function updatePost(Request $request){
        try{
            $user = User::where(['id'=>auth()->id()])->get()->first();
            if($user!=null){
                return $this->_postService->update($request, $user);        
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

    public function updatePostTitle(Request $request){
        try{
            $user = User::where(['id'=>auth()->id()])->get()->first();
            if($user!=null){
                return $this->_postService->updatePostTitle($request, $user);        
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


    public function updatePostBody(Request $request){
        try{
            $user = User::where(['id'=>auth()->id()])->get()->first();
            if($user!=null){
                return $this->_postService->updatePostBody($request, $user);        
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

    public function updatePostTitleAndBody(Request $request){
        try{
            $user = User::where(['id'=>auth()->id()])->get()->first();
            if($user!=null){
                return $this->_postService->updatePostTitleAndBody($request, $user);        
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

    public function updatePostType(Request $request){
        try{
            $user = User::where(['id'=>auth()->id()])->get()->first();
            if($user!=null){
                return $this->_postService->updatePostType($request, $user);        
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
    
    public function findPostById($id){
        try{
            return $this->_postService->findById($id);        
        }
        catch(Exception $e){
            return response()->json(
                Response::_500_internel_server_error_($e->getMessage())
            );
        }
    }

    public function deletePostById($id){
        try{
            $user = User::where(['id'=>auth()->id()])->get()->first();
            if($user!=null){
                return $this->_postService->deleteById($id, $user);        
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

    public function allPosts(){
        try{
            return $this->_postService->allPosts();        
        }
        catch(Exception $e){
            return response()->json(
                Response::_500_internel_server_error_($e->getMessage())
            );
        }
    }

    public function userPosts($id_user_name_email){
        try{
            return $this->_postService->allUserPosts($id_user_name_email);        
        }
        catch(Exception $e){
            return response()->json(
                Response::_500_internel_server_error_($e->getMessage())
            );
        }
    }

    public function current_user_posts(){
        try{
            $user = User::where(['id'=>auth()->id()])->get()->first();
            if($user!=null){
                return $this->_postService->allUserPosts($user->id); 
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
