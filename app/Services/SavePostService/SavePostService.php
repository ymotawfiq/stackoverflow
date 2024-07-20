<?php

namespace App\Services\SavePostService;

use App\Classes\CheckValidation;
use App\Models\ResponseModel\Response;
use App\Models\User;
use App\Repositories\PostRepository\PostRepositoryInterface;
use App\Repositories\PostsListsRepository\PostListRepositoryInterface;
use App\Repositories\SavePostRepository\SavePostRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Nonstandard\Uuid;

class SavePostService implements SavePostServiceInterface
{
    /**
     * Create a new class instance.
     */
    private SavePostRepositoryInterface $_savePostRepository;
    private PostRepositoryInterface $_postRepository;
    private PostListRepositoryInterface $_postListRepository;
    public function __construct(SavePostRepositoryInterface $_savePostRepository,
    PostRepositoryInterface $_postRepository, PostListRepositoryInterface $_postListRepository)
    {
        $this->_savePostRepository = $_savePostRepository;
        $this->_postRepository = $_postRepository;
        $this->_postListRepository = $_postListRepository;
    }
    public function savePost(Request $request, User $user){
        $validator = $this->validate_save_post($request);
        if(!$validator['is_success']){
            return response()->json(
                Response::_400_bad_request_('bad request', $validator)
            );
        }
        if($request->list_id==null||strlen($request->list_id)==0){
            return $this->create_without_list($request, $user);
        }
        return $this->create_with_list($request, $user);
    }
    public function unSavePost($id, User $user){
        $saved_post = $this->_savePostRepository
            ->findUserSavedPostByIdUserId($id, $user->id);
        if($saved_post==null){
            return response()->json(
                Response::_403_forbidden_()
            );
        }
        $this->_savePostRepository->deleteById($id);
        return response()->json(
            Response::_204_no_content_('post unsaved successfully')
        );
    }
    public function getUserSavedPostById($id, User $user){
        $saved_post = $this->_savePostRepository
            ->findUserSavedPostByIdUserId($id, $user->id);
        if($saved_post==null){
            return response()->json(
                Response::_404_not_found_('no saved posts found')
            );
        }
        return response()->json(
            Response::_200_success_('post found successfully', $saved_post)
        );
    }
    public function getUserSavedPosts(User $user){
        $posts = $this->_savePostRepository->findUserSavedPosts($user->id);
        if($posts==null||$posts->count()==0){
            return response()->json(
                Response::_204_no_content_("no posts found")
            );
        }
        return response()->json(
            Response::_200_success_("posts found successfully", $posts)
        );
    }   
    public function getUserSavedPostsByListId($list_id, User $user){
        $posts = $this->_savePostRepository
            ->findUserSavedPostsByList($user->id, $list_id);
        if($posts==null||$posts->count()==0){
            return response()->json(
                Response::_204_no_content_("no posts found")
            );
        }
        return response()->json(
            Response::_200_success_("posts found successfully", $posts)
        );
    }

    private function is_post_saved($post_id, $list_id, $user_id) : bool{
        
        $saved_before = $this->_savePostRepository
            ->findUserSavedPostByListIdUserIdPostId($list_id, $user_id, $post_id);        
        if($saved_before!=null){
            return true;
        }
        return false;
    }
    private function create_with_list(Request $request, User $user){
        $list = $this->_postListRepository
            ->findListByIdUserId($request->list_id, $user->id);
        if($list==null){
            return response()->json(
                Response::_404_not_found_('list not found')
            );
        }
        if($this->is_post_saved($request->post_id, $list->id, $user->id)){
            return response()->json(
                Response::_403_forbidden_('post saved beefore')
            );
        }
        $saved_post = $this->_savePostRepository->create([
            'id'=>Uuid::uuid4()->toString(),
            'post_id'=>$request->post_id,
            'user_id'=> $user->id,
            'list_id'=> $request->list_id,
        ]);
        return response()->json(
            Response::_201_created_("post saved successfully to {$list->name} list", $saved_post)
        );
    }
    private function create_without_list(Request $request, User $user){
        $list = $this->_postListRepository->findByName('default', $user->id);
        if($list==null){
            $list = $this->_postListRepository->create(
                [
                    'user_id'=> $user->id,
                    'id'=>Uuid::uuid4()->toString(),
                    'name'=>'default'
                ]
            );
        }
        if($this->is_post_saved($request->post_id, $list->id, $user->id)){
            return response()->json(
                Response::_403_forbidden_('post saved beefore')
            );
        }
        $saved_post = $this->_savePostRepository->create([
            'user_id'=> $user->id,
            'post_id'=>$request->post_id,
            'list_id'=> $list->id,
            'id'=>Uuid::uuid4()->toString(),
        ]);
        return response()->json(
            Response::_201_created_("post saved successfully to {$list->name} list", $saved_post)
        );
    }

    private function validate_save_post(Request $request){
        $validator = Validator::make($request->all(),[
            'post_id'=>['required', function($attribute, $value, $fail){
                $post = $this->_postRepository->findById($value);
                if($post==null){
                    $fail('post not found');
                }
            }],
            'list_id'=> ['nullable', function($attribute, $value, $fail){
                if($value!=null && strlen($value)>=0){
                    $list = $this->_postListRepository->findById($value);
                    if($list==null){
                        $fail('list not found');
                    }
                }
            }]
        ]);
        return CheckValidation::check_validation($validator);
    }

}
