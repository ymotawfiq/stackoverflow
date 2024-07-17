<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ResponseModel\Response;
use App\Services\AuthService\AccountService\AccountServiceInterface;
use Exception;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    private AccountServiceInterface $_account_service_interface;
    public function __construct(AccountServiceInterface $_account_service_interface){
        $this->_account_service_interface = $_account_service_interface;
    }
    public function update_account(Request $request){
        try{
            $user = auth()->user();
            if($user!=null){
                return $this->_account_service_interface->update_account($request, $user);
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

    public function update_display_name(Request $request){
        try{
            $user = auth()->user();
            if($user!=null){
                return $this->_account_service_interface->update_display_name(
                    $request, $user);
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

    public function update_user_name(Request $request){
        try{
            $user = auth()->user();
            if($user!=null){
                return $this->_account_service_interface->update_user_name(
                    $request, $user);
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
