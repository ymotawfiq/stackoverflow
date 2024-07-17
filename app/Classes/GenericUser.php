<?php

namespace App\Classes;

use App\Models\User;

class GenericUser
{
    public static function get_user_by_id_or_email_or_user_name(string $id_user_name_or_email) {
        if($id_user_name_or_email==null){
            return null;
        }
        $user_by_email = User::where('email', $id_user_name_or_email)->get()->first();
        $user_by_id = User::where('id', $id_user_name_or_email)->get()->first();
        $user_by_user_name = User::where('user_name',$id_user_name_or_email)
            ->get()->first();
        if($user_by_email === null){
            if($user_by_user_name != null){
                return $user_by_user_name;
            }
            else if($user_by_id != null){
                return $user_by_id;
            }
        }
        else if($user_by_user_name === null){
            if($user_by_email != null){
                return $user_by_email;
            }
            else if($user_by_id != null){
                return $user_by_id;
            }
        }
        else if($user_by_id===null){
            if($user_by_user_name != null){
                return $user_by_user_name;
            }
            else if($user_by_email != null){
                return $user_by_email;
            }
        }
        return null;
    }
}
