<?php

namespace App\Http\Controllers;

use App\Models\ResponseModel\Response;
use App\Models\User;
use App\Services\AuthService\RolesService\RolesServiceInterface;
use App\Services\TagsService\TagsServiceInterface;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    private TagsServiceInterface $_tagsServiceInterface;
    private RolesServiceInterface $_rolesServiceInterface;
    public function __construct(TagsServiceInterface $_tagsServiceInterface, 
    RolesServiceInterface $_rolesServiceInterface){
        $this->_tagsServiceInterface = $_tagsServiceInterface;
        $this->_rolesServiceInterface = $_rolesServiceInterface;
    }
    public function create(Request $request){
        try{
            $user = User::where(['id'=>auth()->id()])->get()->first();
            if($user!=null){
                if($this->_rolesServiceInterface->is_user_in_role($user, 'ADMIN')){
                    return $this->_tagsServiceInterface->create($request);
                }
                return response()->json(
                    Response::_403_forbidden_()
                );
            }
            return response()->json(
                Response::_401_un_authorized_()
            );
        }
        catch(\Exception $e){
            return response()->json(
                Response::_500_internel_server_error_($e->getMessage())
            );
        }
    }

    public function update(Request $request){
        try{
            $user = User::where(['id'=>auth()->id()])->get()->first();
            if($user!=null){
                if($this->_rolesServiceInterface->is_user_in_role($user, 'ADMIN')){
                    return $this->_tagsServiceInterface->update($request);
                }
                return response()->json(
                    Response::_403_forbidden_()
                );
            }
            return response()->json(
                Response::_401_un_authorized_()
            );
        }
        catch(\Exception $e){
            return response()->json(
                Response::_500_internel_server_error_($e->getMessage())
            );
        }
    }

    public function delete_by_id($tag_id){
        try{
            $user = User::where(['id'=>auth()->id()])->get()->first();
            if($user!=null){
                if($this->_rolesServiceInterface->is_user_in_role($user, 'ADMIN')){
                    return $this->_tagsServiceInterface->delete_by_id($tag_id);
                }
                return response()->json(
                    Response::_403_forbidden_()
                );
            }
            return response()->json(
                Response::_401_un_authorized_()
            );
        }
        catch(\Exception $e){
            return response()->json(
                Response::_500_internel_server_error_($e->getMessage())
            );
        }
    }

    public function find_by_id($tag_id){
        try{
            return $this->_tagsServiceInterface->find_by_id($tag_id);
        }
        catch(\Exception $e){
            return response()->json(
                Response::_500_internel_server_error_($e->getMessage())
            );
        }
    }

    public function all(){
        try{
            return $this->_tagsServiceInterface->all();
        }
        catch(\Exception $e){
            return response()->json(
                Response::_500_internel_server_error_($e->getMessage())
            );
        }
    }

}
