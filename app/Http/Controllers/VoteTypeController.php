<?php

namespace App\Http\Controllers;

use App\Models\ResponseModel\Response;
use App\Models\User;
use App\Services\AuthService\RolesService\RolesServiceInterface;
use App\Services\VoteTypeService\VoteTypeServiceInterface;
use Exception;
use Illuminate\Http\Request;

class VoteTypeController extends Controller
{
    private VoteTypeServiceInterface $_voteTypeService;
    private RolesServiceInterface $_rolesService;
    public function __construct(VoteTypeServiceInterface $_voteTypeService, 
    RolesServiceInterface $_rolesService){
        $this->_voteTypeService = $_voteTypeService;
        $this->_rolesService = $_rolesService;
    }

    public function addVoteType(Request $request){
        try{
            $user = User::where(['id'=>auth()->id()])->get()->first();
            if($user!=null){
                if($this->_rolesService->isUserInRole($user, 'ADMIN')){
                    return $this->_voteTypeService->addVoteType($request);
                }
                return response()->json(Response::_403_forbidden_());
            }
            return response()->json(Response::_401_un_authorized_());
        }
        catch(Exception $e){
            return response()->json(Response::_500_internel_server_error_($e->getMessage()));
        }
    }

    public function updateVoteType(Request $request){
        try{
            $user = User::where(['id'=>auth()->id()])->get()->first();
            if($user!=null){
                if($this->_rolesService->isUserInRole($user, 'ADMIN')){
                    return $this->_voteTypeService->updateVoteType($request);
                }
                return response()->json(Response::_403_forbidden_());
            }
            return response()->json(Response::_401_un_authorized_());
        }
        catch(Exception $e){
            return response()->json(Response::_500_internel_server_error_($e->getMessage()));
        }
    }

    public function findById($id){
        try{
            return $this->_voteTypeService->findById($id);
        }
        catch(Exception $e){
            return response()->json(Response::_500_internel_server_error_($e->getMessage()));
        }
    }

    public function deleteById($id){
        try{
            $user = User::where(['id'=>auth()->id()])->get()->first();
            if($user!=null){
                if($this->_rolesService->isUserInRole($user, 'ADMIN')){
                    return $this->_voteTypeService->deleteById($id);
                }
                return response()->json(Response::_403_forbidden_());
            }
            return response()->json(Response::_401_un_authorized_());
        }
        catch(Exception $e){
            return response()->json(Response::_500_internel_server_error_($e->getMessage()));
        }
    }

    public function all(){
        try{
            return $this->_voteTypeService->allVoteTypes();
        }
        catch(Exception $e){
            return response()->json(Response::_500_internel_server_error_($e->getMessage()));
        }
    }
}
