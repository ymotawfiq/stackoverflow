<?php

namespace App\Services\BadgeService;

use App\Classes\CheckValidation;
use App\Models\ResponseModel\Response;
use App\Repositories\BadgeRepository\badge_repository_interface;
use App\Repositories\BadgeRepository\BadgeRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class BadgeService implements BadgeServiceInterface
{
    private BadgeRepositoryInterface $_badge_repository_interface;
    public function __construct(BadgeRepositoryInterface $_badge_repository_interface)
    {
        $this->_badge_repository_interface = $_badge_repository_interface;
    }

    public function create($request) : JsonResponse{
        $validator = $this->validate_create($request);
        if(!$validator['is_success']){
            return response()->json(Response::_400_bad_request_('bad request', $validator));
        }
        $new_badge = $this->_badge_repository_interface->create([
            'id'=>Uuid::uuid4()->toString(),
            'name'=> $request->name,
            'normalized_name'=>strtoupper($request->name)
        ]);
        return response()->json(Response::_201_created_('badge created successfully', $new_badge));
    }
    public function update($request) : JsonResponse{
        $validator = $this->validate_update($request);
        if(!$validator['is_success']){
            return response()->json(Response::_400_bad_request_('bad request', $validator));
        }
        $updated_badge = $this->_badge_repository_interface->update($request);
        return response()->json(Response::_200_success_('badge updated successfully', $updated_badge));
    }
    public function delete_by_id(string $id) : JsonResponse{
        $badge = $this->_badge_repository_interface->find_by_id($id);
        if($badge==null){
            return response()->json(
                Response::_404_not_found_('badge not found')
            );
        }
        $this->_badge_repository_interface->delete_by_id($id);
        return response()->json(
            Response::_204_no_content_('badge deleted successfully')
        );
    }
    public function find_by_id(string $id) : JsonResponse{
        $badge = $this->_badge_repository_interface->find_by_id($id);
        if($badge==null){
            return response()->json(
                Response::_404_not_found_('badge not found')
            );
        }
        return response()->json(
            Response::_200_success_('badge found successfully', $badge)
        );
    }
    public function all() : JsonResponse{
        $badges = $this->_badge_repository_interface->all();
        if(empty($badges) || $badges==null || $badges->count()==0){
            return response()->json(
                Response::_204_no_content_('no badges found')
            );
        }
        return response()->json(
            Response::_200_success_('badges found successfully', $badges)
        );
    }

    private function validate_create($request) {
        $validator = Validator::make($request->all(), [
            'name'=>['required','unique:badges', function($attribute, $value, $fail){
                $badge = $this->_badge_repository_interface
                    ->find_by_normalized_name($value);
                if($badge!=null){
                    $fail('name badge already exist');
                }
            }],
        ]);
        return CheckValidation::check_validation($validator);
    }

    private function validate_update($request) {
        $validator = Validator::make($request->all(), [
            'id'=>['required','string'],
            'name'=>['required','unique:badges', function($attribute, $value, $fail){
                $badget = $this->_badge_repository_interface
                    ->find_by_normalized_name($value);
                if($badget!=null){
                    $fail('name badge already exist');
                }
            }]
        ]);
        return CheckValidation::check_validation($validator);
    }
}
