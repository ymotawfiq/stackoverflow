<?php

namespace App\Repositories\PostRepository;

use Illuminate\Support\Facades\DB;

class PostRepository implements PostRepositoryInterface
{
    public function create($data){
        DB::table('posts')->insert($data);
        return $data;
    }
    public function all(){
        return DB::table('posts')->get();
    }
    public function delete_by_id($id){
        DB::table('posts')->where('id', $id)->delete();
    }
    public function find_by_id($id){
        return DB::table('posts')->where('id', $id)->get()->first();
    }
    public function find_post_by_id_user_id($id, $user_id){
        return DB::table('posts')
            ->where(['id' => $id, 'owner_id'=>$user_id])->get()->first();
    }
    public function update($data){
        DB::table('posts')->where('id', $data->id)->update([
            'title'=>$data->title,
            'body'=>$data->body,
            'post_type_id'=> $data->post_type,
        ]);
        return $this->find_by_id($data->id);
    }
    public function update_post_title($data){
        DB::table('posts')->where('id', $data->id)->update([
            'title'=>$data->title,
        ]);
        return $this->find_by_id($data->id);
    }
    public function update_post_body($data){
        DB::table('posts')->where('id', $data->id)->update([
            'body'=>$data->body,
        ]);
        return $this->find_by_id($data->id); 
    }
    public function update_post_type($data){
        DB::table('posts')->where('id', $data->id)->update([
            'post_type_id'=>$data->post_type,
        ]);
        return $this->find_by_id($data->id);
    }
    public function update_post_title_and_body($data){
        DB::table('posts')->where('id', $data->id)->update([
            'title'=>$data->title,
            'body'=>$data->body,
        ]);
        return $this->find_by_id($data->id);
    }
    public function find_user_posts_by_user_id($user_id){
        return DB::table('posts')->where(['owner_id'=> $user_id])->get();
    }
    public function find_post_number_of_answers($post_id){
        return DB::table('posts')->where(['id'=>$post_id])->get()->first()->answers;
    }
    public function find_post_number_of_comments($post_id){
        return DB::table('posts')->where(['id'=>$post_id])->get()->first()->comments;
    }
    public function find_post_number_of_tags($post_id){
        return DB::table('posts')->where(['id'=>$post_id])->get()->first()->tags;
    }
    public function find_post_number_of_views($post_id){
        return DB::table('posts')->where(['id'=>$post_id])->get()->first()->views;
    }

    public function increace_post_views_number($post_id){
        $views = $this->find_post_number_of_views($post_id);
        DB::table('posts')->where(['id'=>$post_id])->update([
            'views'=>$views += 1 
        ]);
        return $views += 1;
    }

    public function increace_post_answer_number($post_id){
        $answers = $this->find_post_number_of_answers($post_id);
        DB::table('posts')->where(['id'=>$post_id])->update([
            'answers'=>$answers += 1 
        ]);
        return $answers += 1;
    }
    public function increace_post_tags_number($post_id){
        $tags = $this->find_post_number_of_tags($post_id);
        DB::table('posts')->where(['id'=>$post_id])->update([
            'tags'=>$tags += 1 
        ]);
        return $tags += 1;
    }
    public function increace_post_comments_number($post_id){
        $comments = $this->find_post_number_of_comments($post_id);
        DB::table('posts')->where(['id'=>$post_id])->update([
            'comments'=>$comments += 1 
        ]);
        return $comments += 1;
    }
}
