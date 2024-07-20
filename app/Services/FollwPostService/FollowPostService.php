<?php

namespace App\Services\FollwPostService;

use App\Classes\CheckValidation;
use App\Models\ResponseModel\Response;
use App\Models\User;
use App\Repositories\FollwPostRepository\FollowPostRepositoryInterface;
use App\Repositories\PostRepository\PostRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FollowPostService implements FollowPostServiceInterface
{
    private FollowPostRepositoryInterface $_followPostRepository;
    private PostRepositoryInterface $_postRepository;
    
    public function __construct(FollowPostRepositoryInterface $_followPostRepository, 
    PostRepositoryInterface $_postRepository)
    {
        $this->_followPostRepository = $_followPostRepository;
        $this->_postRepository = $_postRepository;
    }

    public function followPost($post_id, User $user){
        $is_user_following_post = $this->_followPostRepository
            ->isUserFollowingPost($post_id, $user->id);
        if($is_user_following_post != null){
            return response()->json(
                Response::_400_bad_request_('you already following this post')
            );
        }
        $follow = $this->_followPostRepository->create([
            'user_id'=> $user->id,
            'post_id'=> $post_id,
        ]);
        $this->_postRepository->increacePostFollowersNumber($post_id);
        return response()->json(
            Response::_201_created_('post followed successfully', $follow)
        );
    }

    public function unFollowPost($post_id, User $user){
        $is_user_following_post = $this->_followPostRepository
            ->isUserFollowingPost($post_id, $user->id);
        if($is_user_following_post == null){
            return response()->json(
                Response::_400_bad_request_('you are not following this post')
            );
        }
        $this->_followPostRepository->unFollowPost($post_id, $user->id);
        return response()->json(
            Response::_204_no_content_('post un followed successfully')
        );
    }

    public function findUserFollowingPosts($user_id){
        $posts = $this->_followPostRepository->getUserFollowingPosts($user_id);
        if($posts==null|| $posts->count()== 0){
            return response()->json(
                Response::_204_no_content_('no followed posts found')
            );  
        }
        return response()->json(
            Response::_200_success_('posts you are following found successfully', $posts)
        );
    }

    public function findPostFollowingUsers($post_id){
        $users = $this->_followPostRepository->getPostFollowingUsers($post_id);
        if($users==null|| $users->count()== 0){
            return response()->json(
                Response::_204_no_content_('no following users found')
            );  
        }
        return response()->json(
            Response::_200_success_('users following post found successfully', $users)
        );
    }

    public function isUserFollowingPost($post_id, User $user){
        $follow = $this->_followPostRepository
            ->isUserFollowingPost($post_id, $user->id);
        if($follow==null){
            return response()->json(
                Response::_204_no_content_('you aren\'t following this post')
            );  
        }
        return response()->json(
            Response::_200_success_('you are following this post', $follow)
        );
    }


}
