<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ResponseModel\Response;
use App\Services\AuthService\AccountService\AccountServiceInterface;
use Exception;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    private AccountServiceInterface $_accountService;
    public function __construct(AccountServiceInterface $_accountService){
        $this->_accountService = $_accountService;
    }
    public function updateAccount(Request $request){
        try{
            $user = auth()->user();
            if($user!=null){
                return $this->_accountService->updateAccount($request, $user);
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

    public function updateDisplayName(Request $request){
        try{
            $user = auth()->user();
            if($user!=null){
                return $this->_accountService->updateDisplayName(
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

    public function updateUserName(Request $request){
        try{
            $user = auth()->user();
            if($user!=null){
                return $this->_accountService->updateUserName(
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
