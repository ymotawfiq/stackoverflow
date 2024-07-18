<?php

namespace App\Repositories\FollwPostRepository;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FollowPostRepository implements FollowPostRepositoryInterface
{
    public function create($data){
        DB::table('follow_posts')->insert($data);
        return $data;
    }
    public function all(){
        return DB::table('follow_posts')->get();
    }
    public function un_follow_post($post_id, $user_id){
        DB::table('follow_posts')->where([
            'post_id' => $post_id,
            'user_id'=> $user_id
        ])->delete();
    }
    public function get_user_following_posts($user_id){
        return DB::table('follow_posts')->where(['user_id'=> $user_id])->get();
    }
    public function get_post_following_users($post_id){
        return DB::table('follow_posts')->where(['post_id'=> $post_id])->get();
    }
    public function is_user_following_post($post_id, $user_id){
        return DB::table('follow_posts')->where([
            'post_id' => $post_id,
            'user_id'=> $user_id
        ])->get()->first();
    }
}
