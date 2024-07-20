<?php

namespace App\Http\Controllers;

use App\Models\ResponseModel\Response;
use App\Models\User;
use App\Services\AuthService\RolesService\RolesServiceInterface;
use App\Services\TagsService\TagsServiceInterface;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    private TagsServiceInterface $_tagsService;
    private RolesServiceInterface $_rolesService;
    public function __construct(TagsServiceInterface $_tagsService, 
    RolesServiceInterface $_rolesService){
        $this->_tagsService = $_tagsService;
        $this->_rolesService = $_rolesService;
    }
    public function create(Request $request){
        try{
            $user = User::where(['id'=>auth()->id()])->get()->first();
            if($user!=null){
                if($this->_rolesService->isUserInRole($user, 'ADMIN')){
                    return $this->_tagsService->create($request);
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
                if($this->_rolesService->isUserInRole($user, 'ADMIN')){
                    return $this->_tagsService->update($request);
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

    public function deleteById($tag_id){
        try{
            $user = User::where(['id'=>auth()->id()])->get()->first();
            if($user!=null){
                if($this->_rolesService->isUserInRole($user, 'ADMIN')){
                    return $this->_tagsService->deleteById($tag_id);
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

    public function findById($tag_id){
        try{
            return $this->_tagsService->findById($tag_id);
        }
        catch(\Exception $e){
            return response()->json(
                Response::_500_internel_server_error_($e->getMessage())
            );
        }
    }

    public function all(){
        try{
            return $this->_tagsService->all();
        }
        catch(\Exception $e){
            return response()->json(
                Response::_500_internel_server_error_($e->getMessage())
            );
        }
    }

}
