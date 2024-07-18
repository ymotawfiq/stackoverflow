<?php

namespace App\Services\PostsListsService;

use App\Classes\CheckValidation;
use App\Models\ResponseModel\Response;
use App\Models\User;
use App\Repositories\PostsListsRepository\PostListRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class PostListService implements PostListServiceInterface
{
    /**
     * Create a new class instance.
     */
    private PostListRepositoryInterface $_postListRepositoryInterface;
    public function __construct(PostListRepositoryInterface $_postListRepositoryInterface)
    {
        $this->_postListRepositoryInterface = $_postListRepositoryInterface;
    }
    public function create(Request $request, User $user){
        $validator = $this->validate_create_list($request);
        if(!$validator['is_success']){
            return response()->json(
                Response::_400_bad_request_('bad request', $validator)
            );
        }
        $newList = $this->_postListRepositoryInterface->create([
            'id'=>Uuid::uuid4()->toString(),
            'name'=> $request->name,
            'user_id'=>$user->id
        ]);
        return response()->json(
            Response::_201_created_('list created successfully', $newList)
        );
    }
    public function update(Request $request, User $user){
        $validator = $this->validate_update_list($request);
        if(!$validator['is_success']){
            return response()->json(
                Response::_400_bad_request_('bad request', $validator)
            );
        }
        $list = $this->_postListRepositoryInterface
            ->find_list_by_id_user_id($request->id, $user->id);
        if($list==null){
            return response()->json(
                Response::_403_forbidden_()
            );
        }
        $updatedList = $this->_postListRepositoryInterface->update($request);
        return response()->json(
            Response::_201_created_('list created successfully', $updatedList)
        );
    }
    public function delete_by_id($list_id, User $user){
        $list = $this->_postListRepositoryInterface
            ->find_list_by_id_user_id($list_id, $user->id);
        if($list==null){
            return response()->json(
                Response::_403_forbidden_()
            );
        }
        $this->_postListRepositoryInterface->delete_by_id($list_id);
        return response()->json(
            Response::_204_no_content_('list deleted successfully')
        );
    }
    public function find_by_id($list_id, User $user){
        $exist_list = $this->_postListRepositoryInterface->find_by_id($list_id);
        if($exist_list==null){
            return response()->json(
                Response::_404_not_found_('list not found')
            );            
        }
        $list = $this->_postListRepositoryInterface
            ->find_list_by_id_user_id($list_id, $user->id);
        if($list==null){
            return response()->json(
                Response::_403_forbidden_()
            );
        }
        return response()->json(
            Response::_200_success_('list found successfully', $list)
        );
    }
    public function user_lists(User $user){
        $lists = $this->_postListRepositoryInterface->find_user_lists($user->id);
        if($lists==null||$lists->count()==0){
            return response()->json(
                Response::_204_no_content_('no lists found')
            );
        }
        return response()->json(
            Response::_200_success_('lists found successfully', $lists)
        );
    }


    private function validate_create_list(Request $request){
        $validator = Validator::make($request->all(), [
            'name'=>['required','unique:posts_lists'],
        ]);
        return CheckValidation::check_validation($validator);
    }

    private function validate_update_list(Request $request){
        $validator = Validator::make($request->all(), [
            'id'=>['required',function($attribute, $value, $fail){
                $list = $this->_postListRepositoryInterface->find_by_id($value);
                if($list==null){
                    $fail('list not found');
                }
            }],
            'name'=>['required','unique:posts_lists'],
        ]);
        return CheckValidation::check_validation($validator);
    }

}
