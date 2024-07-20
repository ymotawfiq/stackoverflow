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
    public function deleteById($id){
        DB::table('posts')->where('id', $id)->delete();
    }
    public function findById($id){
        return DB::table('posts')->where('id', $id)->get()->first();
    }
    public function findPostByIdUserId($id, $user_id){
        return DB::table('posts')
            ->where(['id' => $id, 'owner_id'=>$user_id])->get()->first();
    }
    public function update($data){
        DB::table('posts')->where('id', $data->id)->update([
            'title'=>$data->title,
            'body'=>$data->body,
            'post_type_id'=> $data->post_type,
        ]);
        return $this->findById($data->id);
    }
    public function updatePostTitle($data){
        DB::table('posts')->where('id', $data->id)->update([
            'title'=>$data->title,
        ]);
        return $this->findById($data->id);
    }
    public function updatePostBody($data){
        DB::table('posts')->where('id', $data->id)->update([
            'body'=>$data->body,
        ]);
        return $this->findById($data->id); 
    }
    public function updatePostType($data){
        DB::table('posts')->where('id', $data->id)->update([
            'post_type_id'=>$data->post_type,
        ]);
        return $this->findById($data->id);
    }
    public function updatePostTitleAndBody($data){
        DB::table('posts')->where('id', $data->id)->update([
            'title'=>$data->title,
            'body'=>$data->body,
        ]);
        return $this->findById($data->id);
    }
    public function findUserPostsByUserId($user_id){
        return DB::table('posts')->where(['owner_id'=> $user_id])->get();
    }
    public function findPostNumberOfAnswers($post_id){
        return DB::table('posts')->where(['id'=>$post_id])->get()->first()->answers;
    }
    public function findPostNumberOfComments($post_id){
        return DB::table('posts')->where(['id'=>$post_id])->get()->first()->comments;
    }
    public function findPostNumberOfTags($post_id){
        return DB::table('posts')->where(['id'=>$post_id])->get()->first()->tags;
    }
    public function findPostNumberOfViews($post_id){
        return DB::table('posts')->where(['id'=>$post_id])->get()->first()->views;
    }
    public function findPostNumberOfFollowers($post_id){
        return DB::table('posts')->where(['id'=>$post_id])->get()->first()->followers;
    }
    public function increacePostViewsNumber($post_id){
        $views = $this->findPostNumberOfViews($post_id);
        DB::table('posts')->where(['id'=>$post_id])->update([
            'views'=>$views += 1 
        ]);
        return $views += 1;
    }

    public function increacePostAnswerNumber($post_id){
        $answers = $this->findPostNumberOfAnswers($post_id);
        DB::table('posts')->where(['id'=>$post_id])->update([
            'answers'=>$answers += 1 
        ]);
        return $answers += 1;
    }
    public function increacePostTagsNumber($post_id){
        $tags = $this->findPostNumberOfTags($post_id);
        DB::table('posts')->where(['id'=>$post_id])->update([
            'tags'=>$tags += 1 
        ]);
        return $tags += 1;
    }
    public function increacePostCommentsNumber($post_id){
        $comments = $this->findPostNumberOfComments($post_id);
        DB::table('posts')->where(['id'=>$post_id])->update([
            'comments'=>$comments += 1 
        ]);
        return $comments += 1;
    }
    public function increacePostFollowersNumber($post_id){
        $followers = $this->findPostNumberOfFollowers($post_id);
        DB::table('posts')->where(['id'=>$post_id])->update([
            'followers'=>$followers += 1 
        ]);
        return $followers += 1;
    }

    public function isOwner($post_id, $user_id){
        return DB::table('posts')->where([
            'id'=>$post_id,
            'owner_id'=> $user_id
        ])->get()->first();
    }
}
