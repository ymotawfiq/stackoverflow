<?php

namespace App\Services\VoteTypeService;

use App\Classes\CheckValidation;
use App\Models\ResponseModel\Response;
use App\Repositories\VoteTypeRepository\VoteTypeRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class VoteTypeService implements VoteTypeServiceInterface
{
    private VoteTypeRepositoryInterface $_voteTypeRepositoryInterface;
    public function __construct(VoteTypeRepositoryInterface $_voteTypeRepositoryInterface)
    {
        $this->_voteTypeRepositoryInterface = $_voteTypeRepositoryInterface;
    }
    public function add_vote_type(Request $request){
        $validator = $this->validate_add_vote_type($request);
        if(!$validator['is_success']){
            return response()->json(Response::_400_bad_request_('bad request', $validator));
        }
        $vote_type = $this->_voteTypeRepositoryInterface->create([
            'id'=>Uuid::uuid4()->toString(),
            'type'=>$request->type,
            'normalized_type'=>strtoupper($request->type),
        ]);
        return response()->json(
            Response::_201_created_('vote type created successfully', $vote_type)
        );
    }
    public function update_vote_type(Request $request){
        $validator = $this->validate_update_vote_type($request);
        if(!$validator['is_success']){
            return response()->json(Response::_400_bad_request_('bad request', $validator));
        }
        $isVoteTypeExists = $this->_voteTypeRepositoryInterface->find_by_id($request->id);
        if($isVoteTypeExists!=null){
            $vote_type = $this->_voteTypeRepositoryInterface->update($request);
            return response()->json(
                Response::_200_success_('vote type updated successfully', $vote_type)
            );
        }
        return response()->json(
            Response::_404_not_found_('vote type not found')
        );
    }
    public function delete_by_id($id){
        $vote_type = $this->_voteTypeRepositoryInterface->find_by_id($id);
        if($vote_type!=null){
            $this->_voteTypeRepositoryInterface->delete_by_id($id);
            return response()->json(
                Response::_204_no_content_('vote type deleted successfully')
            );
        }
        return response()->json(
            Response::_404_not_found_('vote type not found')
        );
    }
    public function find_by_id($id){
        $vote_type = $this->_voteTypeRepositoryInterface->find_by_id($id);
        if($vote_type!=null){
            return response()->json(
                Response::_200_success_('vote type found successfully', $vote_type)
            );
        }
        return response()->json(
            Response::_404_not_found_('vote type not found')
        );
    }
    public function all_vote_types(){
        $vote_types = $this->_voteTypeRepositoryInterface->all();
        if($vote_types==null||$vote_types->count()==0){
            return response()->json(
                Response::_204_no_content_('no vote types found')
            );
        }
        return response()->json(
            Response::_200_success_('vote types found successfully', $vote_types)
        );
    }

    private function validate_add_vote_type(Request $request){
        $validator = Validator::make($request->all(),[
            'type'=>['required', 'unique:vote_type', function($attribute, $value, $fail) {
                $vote_type = $this->_voteTypeRepositoryInterface->find_by_normalized_type($value);
                if($vote_type!=null){
                    $fail('vote type already exists');
                }
            }]
        ]);
        return CheckValidation::check_validation($validator);
    }

    private function validate_update_vote_type(Request $request){
        $validator = Validator::make($request->all(),[
            'id'=>['required'],
            'type'=>['required', 'unique:vote_type', function($attribute, $value, $fail) {
                $vote_type = $this->_voteTypeRepositoryInterface->find_by_normalized_type($value);
                if($vote_type!=null){
                    $fail('vote type already exists');
                }
            }]
        ]);
        return CheckValidation::check_validation($validator);
    }
}
