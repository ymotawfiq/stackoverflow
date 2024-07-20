<?php

namespace App\Repositories\PostRepository;

use App\Repositories\Generic\AddGetAllInterface;
use App\Repositories\Generic\AllInterface;
use App\Repositories\Generic\CreateInterface;
use App\Repositories\Generic\DeleteInterface;
use App\Repositories\Generic\FindDeleteInterface;
use App\Repositories\Generic\FindInterface;
use App\Repositories\Generic\UpdateInterface;

interface PostRepositoryInterface extends 
    CreateInterface, UpdateInterface, FindInterface, DeleteInterface, AllInterface
{
    public function findUserPostsByUserId($user_id);
    public function findPostByIdUserId($id, $user_id);
    public function findPostNumberOfAnswers($post_id);
    public function findPostNumberOfComments($post_id);
    public function findPostNumberOfTags($post_id);
    public function findPostNumberOfViews($post_id);
    public function findPostNumberOfFollowers($post_id);
    public function updatePostTitle($data);
    public function updatePostBody($data);
    public function updatePostTitleAndBody($data);
    public function updatePostType($data);
    public function increacePostViewsNumber($post_id);
    public function increacePostAnswerNumber($post_id);
    public function increacePostTagsNumber($post_id);
    public function increacePostCommentsNumber($post_id);
    public function increacePostFollowersNumber($post_id);
    public function isOwner($post_id, $user_id);
}
