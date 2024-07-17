<?php

namespace App\Repositories\PostRepository;

use App\Repositories\Generic\AddGetAllInterface;
use App\Repositories\Generic\FindDeleteInterface;
use App\Repositories\Generic\UpdateInterface;

interface PostRepositoryInterface extends AddGetAllInterface, UpdateInterface, FindDeleteInterface
{
    public function find_user_posts_by_user_id($user_id);
    public function find_post_by_id_user_id($id, $user_id);
    public function find_post_number_of_answers($post_id);
    public function find_post_number_of_comments($post_id);
    public function find_post_number_of_tags($post_id);
    public function find_post_number_of_views($post_id);
    public function update_post_title($data);
    public function update_post_body($data);
    public function update_post_title_and_body($data);
    public function update_post_type($data);
    public function increace_post_views_number($post_id);
    public function increace_post_answer_number($post_id);
    public function increace_post_tags_number($post_id);
    public function increace_post_comments_number($post_id);
}
