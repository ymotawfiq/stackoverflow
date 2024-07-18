<?php

namespace App\Repositories\SavePostRepository;

use Illuminate\Support\Facades\DB;

class SavePostRepository implements SavePostRepositoryInterface
{
    public function create($data){
        DB::table('saved_posts')->insert($data);
        return $this->find_by_id($data['id']);
    }
    public function all(){
        return DB::table('saved_posts')->get();
    }
    public function delete_by_id($id){
        DB::table('saved_posts')->where('id', $id)->delete();
    }
    public function find_by_id($id){
        return DB::table('saved_posts')->where('id', $id)->get()->first();
    }
    public function find_user_saved_posts($user_id){
        return DB::table('saved_posts')->where('user_id', $user_id)->get();
    }
    public function find_user_saved_posts_by_list($user_id, $list_id){
        return DB::table('saved_posts')->where([
            'user_id'=> $user_id,
            'list_id'=> $list_id
        ])->get();
    }
    public function find_user_saved_post_by_id_user_id($id, $user_id){
        return DB::table('saved_posts')->where([
            'user_id'=> $user_id,
            'id'=> $id
        ])->get()->first();
    }
    public function find_user_saved_post_by_list_id_user_id_post_id($list_id, $user_id, $post_id){
        return DB::table('saved_posts')->where([
            'user_id'=> $user_id,
            'list_id'=> $list_id,
            'post_id'=>$post_id
        ])->get()->first();
    }

}
