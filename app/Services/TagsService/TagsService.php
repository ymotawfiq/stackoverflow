<?php

namespace App\Services\TagsService;

use App\Classes\CheckValidation;
use App\Models\ResponseModel\Response;
use App\Repositories\TagsRepository\TagsRepositoryInterface;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class TagsService implements TagsServiceInterface
{
    /**
     * Create a new class instance.
     */
    private TagsRepositoryInterface $_tagsRepository;
    public function __construct(TagsRepositoryInterface $_tagsRepository)
    {
        $this->_tagsRepository = $_tagsRepository;
    }
    public function create(Request $request){
        $validator = $this->validate_add_tag($request);
        if(!$validator['is_success']){
            return response()->json(
                Response::_400_bad_request_('bad request', $validator)
            );
        }
        $newTag = $this->_tagsRepository->create([
            'id'=>Uuid::uuid4()->toString(),
            'name'=> $request->name,
            'normalized_name'=>strtoupper($request->name)
        ]);
        return response()->json(
            Response::_201_created_('tag created successfully', $newTag)
        );
    }
    public function update(Request $request){
        $validator = $this->validate_update_tag($request);
        if(!$validator['is_success']){
            return response()->json(
                Response::_400_bad_request_('bad request', $validator)
            );
        }
        $updatedTag = $this->_tagsRepository->update($request);
        return response()->json(
            Response::_200_success_('tag updated successfully', $updatedTag)
        );
    }
    public function deleteById($tag_id){
        $tag = $this->_tagsRepository->findById($tag_id);
        if($tag==null){
            return response()->json(
                Response::_404_not_found_('tag not found')
            );
        }
        $this->_tagsRepository->deleteById($tag_id);
        return response()->json(
            Response::_204_no_content_('tag deleted successfully')
        );
    }
    public function findById($tag_id){
        $tag = $this->_tagsRepository->findById($tag_id);
        if($tag==null){
            return response()->json(
                Response::_404_not_found_('tag not found')
            );
        }
        return response()->json(
            Response::_200_success_('tag found successfully', $tag)
        );
    }
    public function findByName($name){
        $tag = $this->_tagsRepository->findByNormalizedName($name);
        if($tag==null){
            return response()->json(
                Response::_404_not_found_('tag not found')
            );
        }
        return response()->json(
            Response::_200_success_('tag found successfully', $tag)
        );
    }
    public function all(){
        $tags = $this->_tagsRepository->all();
        if($tags==null||$tags->count()==0){
            return response()->json(
                Response::_204_no_content_('no tags found')
            );
        }
        return response()->json(
            Response::_200_success_('tags found successfully', $tags)
        );
    }

    private function validate_add_tag(Request $request){
        $validator = Validator::make($request->all(),[
            'name'=>['required','string','unique:tags', function($attribute, $value, $fail){
                $tag = $this->_tagsRepository->findByNormalizedName($value);
                if($tag!=null){
                    $fail('tag already exists');
                }
            }]
        ]);
        return CheckValidation::check_validation($validator);
    }

    private function validate_update_tag(Request $request){
        $validator = Validator::make($request->all(),[
            'id'=>['required', function($attribute, $value, $fail){
                $tag = $this->_tagsRepository->findById($value);
                if( $tag == null){
                    $fail('tag not found');
                }
            }],
            'name'=>['required','string','unique:tags', function($attribute, $value, $fail){
                $tag = $this->_tagsRepository->findByNormalizedName($value);
                if($tag!=null){
                    $fail('tag already exists');
                }
            }]
        ]);
        return CheckValidation::check_validation($validator);
    }
}
