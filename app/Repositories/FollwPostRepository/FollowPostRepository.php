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
    public function unFollowPost($post_id, $user_id){
        DB::table('follow_posts')->where([
            'post_id' => $post_id,
            'user_id'=> $user_id
        ])->delete();
    }
    public function getUserFollowingPosts($user_id){
        return DB::table('follow_posts')->where(['user_id'=> $user_id])->get();
    }
    public function getPostFollowingUsers($post_id){
        return DB::table('follow_posts')->where(['post_id'=> $post_id])->get();
    }
    public function isUserFollowingPost($post_id, $user_id){
        return DB::table('follow_posts')->where([
            'post_id' => $post_id,
            'user_id'=> $user_id
        ])->get()->first();
    }
}
