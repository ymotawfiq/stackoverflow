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
    private PostServiceInterface $_post_service_interface;
    private RolesServiceInterface $_roles_service_interface;
    public function __construct(PostServiceInterface $_post_service_interface, 
    RolesServiceInterface $_roles_service_interface){
        $this->_post_service_interface = $_post_service_interface;
        $this->_roles_service_interface = $_roles_service_interface;
    }

    public function add_post(Request $request){
        try{
            $user = User::where(['id'=>auth()->id()])->get()->first();
            if($user!=null){
                return $this->_post_service_interface->create($request, $user);        
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

    public function update_post(Request $request){
        try{
            $user = User::where(['id'=>auth()->id()])->get()->first();
            if($user!=null){
                return $this->_post_service_interface->update($request, $user);        
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

    public function update_post_title(Request $request){
        try{
            $user = User::where(['id'=>auth()->id()])->get()->first();
            if($user!=null){
                return $this->_post_service_interface->update_post_title($request, $user);        
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


    public function update_post_body(Request $request){
        try{
            $user = User::where(['id'=>auth()->id()])->get()->first();
            if($user!=null){
                return $this->_post_service_interface->update_post_body($request, $user);        
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

    public function update_post_title_body(Request $request){
        try{
            $user = User::where(['id'=>auth()->id()])->get()->first();
            if($user!=null){
                return $this->_post_service_interface->update_post_title_and_body($request, $user);        
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

    public function update_post_type(Request $request){
        try{
            $user = User::where(['id'=>auth()->id()])->get()->first();
            if($user!=null){
                return $this->_post_service_interface->update_post_type($request, $user);        
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
    
    public function find_post_by_id($id){
        try{
            return $this->_post_service_interface->find_by_id($id);        
        }
        catch(Exception $e){
            return response()->json(
                Response::_500_internel_server_error_($e->getMessage())
            );
        }
    }

    public function delete_post_by_id($id){
        try{
            $user = User::where(['id'=>auth()->id()])->get()->first();
            if($user!=null){
                return $this->_post_service_interface->delete_by_id($id, $user);        
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

    public function all_posts(){
        try{
            return $this->_post_service_interface->all_posts();        
        }
        catch(Exception $e){
            return response()->json(
                Response::_500_internel_server_error_($e->getMessage())
            );
        }
    }

    public function user_posts($id_user_name_email){
        try{
            return $this->_post_service_interface->all_user_posts($id_user_name_email);        
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
                return $this->_post_service_interface->all_user_posts($user->id); 
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
