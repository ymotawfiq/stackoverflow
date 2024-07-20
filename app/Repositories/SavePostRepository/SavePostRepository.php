<?php

namespace App\Repositories\SavePostRepository;

use Illuminate\Support\Facades\DB;

class SavePostRepository implements SavePostRepositoryInterface
{
    public function create($data){
        DB::table('saved_posts')->insert($data);
        return $this->findById($data['id']);
    }
    public function all(){
        return DB::table('saved_posts')->get();
    }
    public function deleteById($id){
        DB::table('saved_posts')->where('id', $id)->delete();
    }
    public function findById($id){
        return DB::table('saved_posts')->where('id', $id)->get()->first();
    }
    public function findUserSavedPosts($user_id){
        return DB::table('saved_posts')->where('user_id', $user_id)->get();
    }
    public function findUserSavedPostsByList($user_id, $list_id){
        return DB::table('saved_posts')->where([
            'user_id'=> $user_id,
            'list_id'=> $list_id
        ])->get();
    }
    public function findUserSavedPostByIdUserId($id, $user_id){
        return DB::table('saved_posts')->where([
            'user_id'=> $user_id,
            'id'=> $id
        ])->get()->first();
    }
    public function findUserSavedPostByListIdUserIdPostId($list_id, $user_id, $post_id){
        return DB::table('saved_posts')->where([
            'user_id'=> $user_id,
            'list_id'=> $list_id,
            'post_id'=>$post_id
        ])->get()->first();
    }

}
