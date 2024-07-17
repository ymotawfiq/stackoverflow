<?php

namespace App\Classes;

use App\Models\ResponseModel\Response;

class CheckValidation
{
    public static function check_validation($validator) : array{
        if($validator->fails()){
            return Response::_400_bad_request_('bad request',
                     ['errors'=>$validator->errors()]);
        }
        return Response::_200_success_();
    }
}
