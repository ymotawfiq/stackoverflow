<?php

namespace App\Repositories\PostsListsRepository;

use Illuminate\Support\Facades\DB;

class PostListRepository implements PostListRepositoryInterface
{
    public function create($data){
        DB::table('posts_lists')->insert($data);
        return $this->findById($data['id']);
    }
    public function all(){
        return DB::table('posts_lists')->get();
    }
    public function findUserLists($user_id){
        return DB::table('posts_lists')->where(['user_id'=>$user_id])->get();
    }
    public function deleteById($id){
        DB::table('posts_lists')->where('id', $id)->delete();
    }
    public function findById($id){
        return DB::table('posts_lists')->where('id', $id)->get()->first();
    }
    public function findListByIdUserId($id, $user_id){
        return DB::table('posts_lists')->where([
            'user_id'=>$user_id,
            'id'=>$id
        ])->get()->first();
    }
    public function findByName($name, $user_id){
        return DB::table('posts_lists')->where([
            'user_id'=>$user_id,
            'name'=>strtolower($name)
        ])->get()->first();
    }
    public function update($data){
        DB::table('posts_lists')->where('id', $data->id)->update([
            'name'=>$data->name
        ]);
        return $this->findById($data->id);
    }
}
