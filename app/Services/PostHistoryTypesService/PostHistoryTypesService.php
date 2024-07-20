<?php

namespace App\Services\PostHistoryTypesService;

use App\Classes\CheckValidation;
use App\Models\ResponseModel\Response;
use Illuminate\Http\Request;
use App\Repositories\PostHistoryTypesRepository\PostHistoryTypesRepositoryInterface;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class PostHistoryTypesService implements PostHistoryTypesServiceInterface
{
    /**
     * Create a new class instance.
     */
    private PostHistoryTypesRepositoryInterface $_postHistoryTypesRepository;
    public function __construct(PostHistoryTypesRepositoryInterface $_postHistoryTypesRepository)
    {
        $this->_postHistoryTypesRepository = $_postHistoryTypesRepository;
    }
    public function create(Request $request){
        $validator = $this->validate_add_type($request);
        if(!$validator['is_success']){
            return response()->json(
                Response::_400_bad_request_('bad request', $validator)
            );
        }
        $type = $this->_postHistoryTypesRepository->create([
            'id'=>Uuid::uuid4()->toString(),
            'type'=>$request->type,
            'normalized_type'=>strtoupper($request->type),
        ]);
        return response()->json(
            Response::_201_created_('history type created successfully', $type)
        );
    }
    public function update(Request $request){
        $validator = $this->validate_update_type($request);
        if(!$validator['is_success']){
            return response()->json(
                Response::_400_bad_request_('bad request', $validator)
            );
        }
        $updated_type = $this->_postHistoryTypesRepository->update($request);
        return response()->json(
            Response::_200_success_('history type updated successfully', $updated_type)
        );
    }
    public function deleteById($id){
        $type = $this->_postHistoryTypesRepository->findById($id);
        if($type==null){
            return response()->json(
                Response::_404_not_found_('history type not found')
            );
        }
        $this->_postHistoryTypesRepository->deleteById($id);
        return response()->json(
            Response::_204_no_content_('history type deleted successfully')
        );
    }
    public function findById($id){
        $type = $this->_postHistoryTypesRepository->findById($id);
        if($type==null){
            return response()->json(
                Response::_404_not_found_('history type not found')
            );
        }
        return response()->json(
            Response::_200_success_('history type found successfully', $type)
        );
    }
    public function all(){
        $types = $this->_postHistoryTypesRepository->all();
        if($types==null||count($types)==0){
            return response()->json(
                Response::_204_no_content_('no types found')
            );   
        }
        return response()->json(
            Response::_200_success_('types found successfully', $types)
        );
    }

    private function validate_add_type(Request $request){
        $validator = Validator::make($request->all(), [
            'type'=>['required','string','unique:post_history_types', 
                function($attribute, $value, $fail){
                    $type = $this->_postHistoryTypesRepository
                        ->findByNormalizedType($value);
                    if($type!=null){
                        $fail('type already exists');
                    }
                }],
        ]);
        return CheckValidation::check_validation($validator);
    }

    private function validate_update_type(Request $request){
        $validator = Validator::make($request->all(), [
            'type'=>['required','string','unique:post_history_types', 
                function($attribute, $value, $fail){
                    $type = $this->_postHistoryTypesRepository
                        ->findByNormalizedType($value);
                    if($type!=null){
                        $fail('type already exists');
                    }
                }],
            'id'=>['required','string', function($attribute, $value, $fail){
                    $type = $this->_postHistoryTypesRepository
                        ->findById($value);
                    if($type==null){
                        $fail('type not found');
                    }
                }],
        ]);
        return CheckValidation::check_validation($validator);
    }
}
