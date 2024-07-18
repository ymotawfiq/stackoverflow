<?php

namespace App\Repositories\PostsListsRepository;

use Illuminate\Support\Facades\DB;

class PostListRepository implements PostListRepositoryInterface
{
    public function create($data){
        DB::table('posts_lists')->insert($data);
        return $this->find_by_id($data['id']);
    }
    public function all(){
        return DB::table('posts_lists')->get();
    }
    public function find_user_lists($user_id){
        return DB::table('posts_lists')->where(['user_id'=>$user_id])->get();
    }
    public function delete_by_id($id){
        DB::table('posts_lists')->where('id', $id)->delete();
    }
    public function find_by_id($id){
        return DB::table('posts_lists')->where('id', $id)->get()->first();
    }
    public function find_list_by_id_user_id($id, $user_id){
        return DB::table('posts_lists')->where([
            'user_id'=>$user_id,
            'id'=>$id
        ])->get()->first();
    }
    public function find_by_name($name, $user_id){
        return DB::table('posts_lists')->where([
            'user_id'=>$user_id,
            'name'=>strtolower($name)
        ])->get()->first();
    }
    public function update($data){
        DB::table('posts_lists')->where('id', $data->id)->update([
            'name'=>$data->name
        ]);
        return $this->find_by_id($data->id);
    }
}
