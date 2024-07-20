<?php

namespace App\Http\Controllers;

use App\Models\ResponseModel\Response;
use App\Models\User;
use App\Services\AuthService\RolesService\RolesServiceInterface;
use App\Services\PostHistoryTypesService\PostHistoryTypesServiceInterface;
use Illuminate\Http\Request;

class PostHistoryTypesController extends Controller
{
    private PostHistoryTypesServiceInterface $_postHistoryTypesServiceInterface;
    private RolesServiceInterface $_rolesServiceInterface;
    public function __construct(PostHistoryTypesServiceInterface $_postHistoryTypesServiceInterface, 
    RolesServiceInterface $_rolesServiceInterface){
        $this->_postHistoryTypesServiceInterface = $_postHistoryTypesServiceInterface;
        $this->_rolesServiceInterface = $_rolesServiceInterface;
    }
    public function create(Request $request){
        try{
            $user = User::where('id', auth()->id())->get()->first();
            if($user!=null){
                if($this->_rolesServiceInterface->is_user_in_role($user, 'ADMIN')){
                    return $this->_postHistoryTypesServiceInterface->create($request);
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
                if($this->_rolesServiceInterface->is_user_in_role($user, 'ADMIN')){
                    return $this->_postHistoryTypesServiceInterface->update($request);
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

    public function delete_by_id($id){
        try{
            $user = User::where('id', auth()->id())->get()->first();
            if($user!=null){
                if($this->_rolesServiceInterface->is_user_in_role($user, 'ADMIN')){
                    return $this->_postHistoryTypesServiceInterface->delete_by_id($id);
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

    public function find_by_id($id){
        try{
            return $this->_postHistoryTypesServiceInterface->find_by_id($id);
        }
        catch(\Exception $e){
            return response()->json(
                Response::_500_internel_server_error_($e->getMessage())
            );
        }
    }

    public function all(){
        try{
            return $this->_postHistoryTypesServiceInterface->all();
        }
        catch(\Exception $e){
            return response()->json(
                Response::_500_internel_server_error_($e->getMessage())
            );
        }
    }

}
