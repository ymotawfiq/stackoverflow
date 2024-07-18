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
    private FollowPostRepositoryInterface $_followPostRepositoryInterface;
    private PostRepositoryInterface $_postRepositoryInterface;
    
    public function __construct(FollowPostRepositoryInterface $_followPostRepositoryInterface, 
    PostRepositoryInterface $_postRepositoryInterface)
    {
        $this->_followPostRepositoryInterface = $_followPostRepositoryInterface;
        $this->_postRepositoryInterface = $_postRepositoryInterface;
    }

    public function follow_post($post_id, User $user){
        $is_user_following_post = $this->_followPostRepositoryInterface
            ->is_user_following_post($post_id, $user->id);
        if($is_user_following_post != null){
            return response()->json(
                Response::_400_bad_request_('you already following this post')
            );
        }
        $follow = $this->_followPostRepositoryInterface->create([
            'user_id'=> $user->id,
            'post_id'=> $post_id,
        ]);
        $this->_postRepositoryInterface->increace_post_followers_number($post_id);
        return response()->json(
            Response::_201_created_('post followed successfully', $follow)
        );
    }

    public function un_follow_post($post_id, User $user){
        $is_user_following_post = $this->_followPostRepositoryInterface
            ->is_user_following_post($post_id, $user->id);
        if($is_user_following_post == null){
            return response()->json(
                Response::_400_bad_request_('you are not following this post')
            );
        }
        $this->_followPostRepositoryInterface->un_follow_post($post_id, $user->id);
        return response()->json(
            Response::_204_no_content_('post un followed successfully')
        );
    }

    public function find_user_following_posts($user_id){
        $posts = $this->_followPostRepositoryInterface->get_user_following_posts($user_id);
        if($posts==null|| $posts->count()== 0){
            return response()->json(
                Response::_204_no_content_('no followed posts found')
            );  
        }
        return response()->json(
            Response::_200_success_('posts you are following found successfully', $posts)
        );
    }

    public function find_post_following_users($post_id){
        $users = $this->_followPostRepositoryInterface->get_post_following_users($post_id);
        if($users==null|| $users->count()== 0){
            return response()->json(
                Response::_204_no_content_('no following users found')
            );  
        }
        return response()->json(
            Response::_200_success_('users following post found successfully', $users)
        );
    }

    public function is_user_following_post($post_id, User $user){
        $follow = $this->_followPostRepositoryInterface
            ->is_user_following_post($post_id, $user->id);
        if($follow==null){
            return response()->json(
                Response::_204_no_content_('you aren\'t following this post')
            );  
        }
        return response()->json(
            Response::_200_success_('you are following this post', $follow)
        );
    }

    private function validate_follow_post(Request $request){
        $validator = Validator::make($request->all(),[
            'post_id'=>['required',function($attribute, $value, $fail) {
                $post = $this->_postRepositoryInterface->find_by_id($value);
                if($post==null){
                    $fail('post not found');
                }
            }],
        ]);
        return CheckValidation::check_validation($validator);
    }

}
