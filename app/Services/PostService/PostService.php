<?php

namespace App\Services\PostService;

use App\Classes\CheckValidation;
use App\Classes\GenericUser;
use App\Models\DTOs\UpdatePostDto;
use App\Models\DTOs\UpdatePostTypeDto;
use App\Models\ResponseModel\Response;
use App\Models\User;
use App\Repositories\PostRepository\PostRepositoryInterface;
use App\Repositories\PostTypeRepository\PostTypeRepository;
use App\Repositories\PostTypeRepository\PostTypeRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class PostService implements PostServiceInterface
{
    private PostRepositoryInterface $_post_repository_interface;
    private PostTypeRepositoryInterface $_post_type_repository_interface;
    public function __construct(PostRepositoryInterface $_post_repository_interface, 
    PostTypeRepositoryInterface $_post_type_repository_interface)
    {
        $this->_post_repository_interface = $_post_repository_interface;
        $this->_post_type_repository_interface = $_post_type_repository_interface;
    }
    public function create(Request $request, User $user){
        $validator = $this->validate_create_post($request);
        if(!$validator['is_success']){
            return response()->json(
                Response::_400_bad_request_('bad request', $validator)
            );
        }
        $new_post = $this->_post_repository_interface->create([
            'id'=>Uuid::uuid4()->toString(),
            'title'=> $request->title,
            'body'=>$request->body,
            'post_type_id'=> $this->post_type( $request->post_type )->id,
            'comments'=>0,
            'answers'=>0,
            'tags'=>0,
            'views'=>0,
            'owner_id'=>$user->id
        ]);
        return response()->json(
            Response::_201_created_('post created successfully', $new_post)
        );
    }
    public function update(Request $request, User $user){
        $validator = $this->validate_update_post($request);
        if(!$validator['is_success']){
            return response()->json(
                Response::_400_bad_request_('bad request', $validator)
            );
        }
        $is_user_post = $this->_post_repository_interface
            ->find_post_by_id_user_id($request->id, $user->id);
        if($is_user_post==null){
            return response()->json(
                Response::_403_forbidden_()
            );
        }
        $updated_post_dto = new UpdatePostDto($request->id, $request->title,
            $request->body, $request->post_type);
        $updated_post_dto->post_type = $this->post_type( $request->post_type )->id;
        $updated_post = $this->_post_repository_interface->update($updated_post_dto);
        return response()->json(
            Response::_200_success_('post updated successfully', $updated_post)
        );
    }
    public function find_by_id($post_id){
        $post = $this->_post_repository_interface->find_by_id($post_id);
        if($post==null){
            return response()->json(
                Response::_404_not_found_('post not found')
            );
        }
        $this->_post_repository_interface->increace_post_views_number($post->id);
        return response()->json(
            Response::_200_success_('post found successfully', $post)
        );
    }
    public function delete_by_id($post_id, User $user){
        $post = $this->_post_repository_interface
            ->find_post_by_id_user_id($post_id, $user->id);
        if($post==null){
            return response()->json(
                Response::_403_forbidden_()
            );
        }
        $this->_post_repository_interface->delete_by_id($post_id);
        return response()->json(
            Response::_204_no_content_('post deleted successfully')
        );
    }
    public function all_posts(){
        $posts = $this->_post_repository_interface->all();
        if($posts==null || $posts->count()==0){
            return response()->json(
                Response::_204_no_content_('no posts found')
            );  
        }
        return response()->json(
            Response::_200_success_('post found successfully', $posts)
        );
    }
    public function all_user_posts($user_id_user_name_email){
        $user = GenericUser::get_user_by_id_or_email_or_user_name( 
            $user_id_user_name_email );
        if($user==null){
            return response()->json(
                Response::_404_not_found_('user not found')
            );
        }
        $posts = $this->_post_repository_interface
            ->find_user_posts_by_user_id($user->id);
        if($posts==null || $posts->count()==0){
            return response()->json(
                Response::_204_no_content_('no posts found')
            );  
        }
        return response()->json(
            Response::_200_success_('post found successfully', $posts)
        );
    }
    public function update_post_title(Request $request, User $user){
        $validator = $this->validate_update_post_title($request);
        if(!$validator['is_success']){
            return response()->json(
                Response::_400_bad_request_('bad request', $validator)
            );
        }
        $is_user_post = $this->_post_repository_interface
            ->find_post_by_id_user_id($request->id, $user->id);
        if($is_user_post==null){
            return response()->json(
                Response::_403_forbidden_()
            );
        }
        $updated_post = $this->_post_repository_interface->update_post_title($request);
        return response()->json(
            Response::_200_success_('post title updated successfully', $updated_post)
        );
    }
    public function update_post_body(Request $request, User $user){
        $validator = $this->validate_update_post_body($request);
        if(!$validator['is_success']){
            return response()->json(
                Response::_400_bad_request_('bad request', $validator)
            );
        }
        $is_user_post = $this->_post_repository_interface
            ->find_post_by_id_user_id($request->id, $user->id);
        if($is_user_post==null){
            return response()->json(
                Response::_403_forbidden_()
            );
        }
        $updated_post = $this->_post_repository_interface->update_post_body($request);
        return response()->json(
            Response::_200_success_('post body updated successfully', $updated_post)
        );
    }

    public function update_post_type(Request $request, User $user){
        $validator = $this->validate_update_post_type($request);
        if(!$validator['is_success']){
            return response()->json(
                Response::_400_bad_request_('bad request', $validator)
            );
        }
        $is_user_post = $this->_post_repository_interface
            ->find_post_by_id_user_id($request->id, $user->id);
        if($is_user_post==null){
            return response()->json(
                Response::_403_forbidden_()
            );
        }
        $post_type_dto = new UpdatePostTypeDto($request->id, $request->post_type);
        $post_type_dto->post_type = $this->post_type($request->post_type)->id;
        $updated_post = $this->_post_repository_interface->update_post_type($post_type_dto);
        return response()->json(
            Response::_200_success_('post type updated successfully', $updated_post)
        );
    }

    public function update_post_title_and_body(Request $request, User $user){
        $validator = $this->validate_update_post_title_body($request);
        if(!$validator['is_success']){
            return response()->json(
                Response::_400_bad_request_('bad request', $validator)
            );
        }
        $is_user_post = $this->_post_repository_interface
            ->find_post_by_id_user_id($request->id, $user->id);
        if($is_user_post==null){
            return response()->json(
                Response::_403_forbidden_()
            );
        }
        $updated_post = $this->_post_repository_interface
            ->update_post_title_and_body($request);
        return response()->json(
            Response::_200_success_('post title and body updated successfully', $updated_post)
        );
    }


    private function validate_create_post(Request $request){
        $validator = Validator::make($request->all(), [
            'title'=>['required', 'min:10'],
            'body'=>['required', 'min:10'],
            'post_type'=>['required', function($attribute, $value, $fail) {
                $post_type = $this->post_type( $value );
                if( $post_type == null ){
                    $fail('post type not found');
                }
            }],
        ]);
        return CheckValidation::check_validation($validator);
    }

    private function validate_update_post(Request $request){
        $validator = Validator::make($request->all(), [
            'id'=>['required', function($attribute, $value, $fail) {
                $post = $this->_post_repository_interface->find_by_id( $value );
                if( $post == null ){
                    $fail('post not found');
                }
            }],
            'title'=>['required', 'min:10'],
            'body'=>['required', 'min:10'],
            'post_type'=>['required', function($attribute, $value, $fail) {
                $post_type = $this->post_type( $value );
                if( $post_type == null ){
                    $fail('post type not found');
                }
            }],
        ]);
        return CheckValidation::check_validation($validator);
    }

    private function validate_update_post_title(Request $request){
        $validator = Validator::make($request->all(), [
            'id'=>['required', function($attribute, $value, $fail) {
                $post = $this->_post_repository_interface->find_by_id( $value );
                if( $post == null ){
                    $fail('post not found');
                }
            }],
            'title'=>['required', 'min:10'],
        ]);
        return CheckValidation::check_validation($validator);
    }

    private function validate_update_post_body(Request $request){
        $validator = Validator::make($request->all(), [
            'id'=>['required', function($attribute, $value, $fail) {
                $post = $this->_post_repository_interface->find_by_id( $value );
                if( $post == null ){
                    $fail('post not found');
                }
            }],
            'body'=>['required', 'min:10'],
        ]);
        return CheckValidation::check_validation($validator);
    }

    private function validate_update_post_title_body(Request $request){
        $validator = Validator::make($request->all(), [
            'id'=>['required', function($attribute, $value, $fail) {
                $post = $this->_post_repository_interface->find_by_id( $value );
                if( $post == null ){
                    $fail('post not found');
                }
            }],
            'body'=>['required', 'min:10'],
            'title'=>['required', 'min:10'],
        ]);
        return CheckValidation::check_validation($validator);
    }

    private function validate_update_post_type(Request $request){
        $validator = Validator::make($request->all(), [
            'id'=>['required', function($attribute, $value, $fail) {
                $post = $this->_post_repository_interface->find_by_id( $value );
                if( $post == null ){
                    $fail('post not found');
                }
            }],
            'post_type'=>['required', function($attribute, $value, $fail) {
                $post_type = $this->post_type( $value );
                if( $post_type == null ){
                    $fail('post type not found');
                }
            }],
        ]);
        return CheckValidation::check_validation($validator);
    }

    private function post_type($id_or_type){
        $post_type_1 = $this->_post_type_repository_interface->find_by_id($id_or_type);
        $post_type_2 = $this->_post_type_repository_interface->find_by_normalized_type($id_or_type);
        return $post_type_1==null?$post_type_2:$post_type_1;
    }


}
