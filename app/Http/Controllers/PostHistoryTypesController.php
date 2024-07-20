<?php

namespace App\Http\Controllers;

use App\Models\ResponseModel\Response;
use App\Models\User;
use App\Services\AuthService\RolesService\RolesServiceInterface;
use App\Services\PostHistoryTypesService\PostHistoryTypesServiceInterface;
use Illuminate\Http\Request;

class PostHistoryTypesController extends Controller
{
    private PostHistoryTypesServiceInterface $_postHistoryTypesService;
    private RolesServiceInterface $_rolesService;
    public function __construct(PostHistoryTypesServiceInterface $_postHistoryTypesService, 
    RolesServiceInterface $_rolesService){
        $this->_postHistoryTypesService = $_postHistoryTypesService;
        $this->_rolesService = $_rolesService;
    }
    public function create(Request $request){
        try{
            $user = User::where('id', auth()->id())->get()->first();
            if($user!=null){
                if($this->_rolesService->isUserInRole($user, 'ADMIN')){
                    return $this->_postHistoryTypesService->create($request);
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
            $user = User::where('id', auth()->id())->get()->first();
            if($user!=null){
                if($this->_rolesService->isUserInRole($user, 'ADMIN')){
                    return $this->_postHistoryTypesService->update($request);
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

    public function deleteById($id){
        try{
            $user = User::where('id', auth()->id())->get()->first();
            if($user!=null){
                if($this->_rolesService->isUserInRole($user, 'ADMIN')){
                    return $this->_postHistoryTypesService->deleteById($id);
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

    public function findById($id){
        try{
            return $this->_postHistoryTypesService->findById($id);
        }
        catch(\Exception $e){
            return response()->json(
                Response::_500_internel_server_error_($e->getMessage())
            );
        }
    }

    public function all(){
        try{
            return $this->_postHistoryTypesService->all();
        }
        catch(\Exception $e){
            return response()->json(
                Response::_500_internel_server_error_($e->getMessage())
            );
        }
    }

}
