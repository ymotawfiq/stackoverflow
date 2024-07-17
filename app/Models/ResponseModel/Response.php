<?php

namespace App\Models\ResponseModel;

class Response
{
    public static function _200_success_($message= "success", $data=null){
        return [
            'is_success'=>true,
            'status_code'=>200,
            'message'=>$message,
            'data'=>$data
        ];
    }

    public static function _201_created_($message= "created", $data=null){
        return [
            'is_success'=>true,
            'status_code'=>201,
            'message'=>$message,
            'data'=>$data
        ];
    }

    public static function _204_no_content_($message= "no content"){
        return [
            'is_success'=>true,
            'status_code'=>204,
            'message'=>$message,
        ];
    }

    public static function _400_bad_request_($message= "bad request", $data=null){
        return [
            'is_success'=>false,
            'status_code'=>400,
            'message'=>$message,
            'data'=>$data
        ];
    }

    public static function _401_un_authorized_($message= "un authorized"){
        return [
            'is_success'=>false,
            'status_code'=>401,
            'message'=>$message,
        ];
    }

    public static function _403_forbidden_($message= "forbidden"){
        return [
            'is_success'=>false,
            'status_code'=>403,
            'message'=>$message,
        ];
    }

    public static function _404_not_found_($message= "not found"){
        return [
            'is_success'=>false,
            'status_code'=>404,
            'message'=>$message,
        ];
    }

    public static function _500_internel_server_error_($message= "internel server error"){
        return [
            'is_success'=>false,
            'status_code'=>500,
            'message'=>$message,
        ];
    }
}
