<?php

namespace App\Services\PostTypeService;

use App\Classes\CheckValidation;
use App\Models\ResponseModel\Response;
use App\Repositories\PostTypeRepository\PostTypeRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class PostTypeService implements PostTypeServiceInterface
{
    private PostTypeRepositoryInterface $_post_type_repository;
    public function __construct(PostTypeRepositoryInterface $_post_type_repository)
    {
        $this->_post_type_repository = $_post_type_repository;
    }

    public function add_post_type(Request $request){
        $validator = $this->validate_add_request($request);
        if(!$validator['is_success']){
            return response()->json(Response::_400_bad_request_('bad request', $validator));
        }
        $post_type = $this->_post_type_repository->create([
            'id'=>Uuid::uuid4()->toString(),
            'type'=>$request->type,
            'normalized_type'=>strtoupper($request->type)
        ]);
        return response()->json(Response::_201_created_('post type created successfully', $post_type));
    }
    public function update_post_type(Request $request){
        $validator = $this->validate_update_request($request);
        if(!$validator['is_success']){
            return response()->json(Response::_400_bad_request_('bad request', $validator));
        }
        $post_type = $this->_post_type_repository->update($request);
        return response()->json(Response::_200_success_('post type updated successfully', $post_type));
    }
    public function find_post_type($id){
        $post_type = $this->_post_type_repository->find_by_id($id);
        if($post_type==null){
            return response()->json(Response::_404_not_found_('post type not found'));
        }
        return response()->json(Response::_200_success_('post type found successfully', $post_type));
    }
    public function delete_post_type($id){
        $post_type = $this->_post_type_repository->find_by_id($id);
        if($post_type==null){
            return response()->json(Response::_404_not_found_('post type not found'));
        }
        $this->_post_type_repository->delete_by_id($id);
        return response()->json(Response::_204_no_content_('post type deleted successfully'));
    }
    public function all(){
        $post_types = $this->_post_type_repository->all();
        if($post_types==null||$post_types->count()==0){
            return response()->json(Response::_204_no_content_('no post types found'));    
        }
        return response()->json(Response::_200_success_('post types found successfully', $post_types));
    }

    private function validate_add_request(Request $request){
        $validator = Validator::make($request->all(), [
            'type'=>['required','string','unique:post_types'],
        ]);
        return CheckValidation::check_validation($validator);
    }

    private function validate_update_request(Request $request){
        $validator = Validator::make($request->all(), [
            'id'=>['required'],
            'type'=>['required', 'unique:post_types', function($attribute, $value, $fail){
                $post_type = $this->_post_type_repository->find_by_normalized_type( $value );
                if($post_type!=null){
                    $fail('post type already exists');
                }
            }],
        ]);
        return CheckValidation::check_validation($validator);
    }
}
