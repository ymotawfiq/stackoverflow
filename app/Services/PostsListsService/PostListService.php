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

    private PostListRepositoryInterface $_postListRepository;
    public function __construct(PostListRepositoryInterface $_postListRepository)
    {
        $this->_postListRepository = $_postListRepository;
    }
    public function create(Request $request, User $user){
        $validator = $this->validate_create_list($request);
        if(!$validator['is_success']){
            return response()->json(
                Response::_400_bad_request_('bad request', $validator)
            );
        }
        $newList = $this->_postListRepository->create([
            'id'=>Uuid::uuid4()->toString(),
            'name'=> strtolower($request->name),
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
        $list = $this->_postListRepository->findListByIdUserId($request->id, $user->id);
        if($list==null){
            return response()->json(
                Response::_403_forbidden_()
            );
        }
        $updatedList = $this->_postListRepository->update($request);
        return response()->json(
            Response::_201_created_('list created successfully', $updatedList)
        );
    }
    public function deleteById($list_id, User $user){
        $list = $this->_postListRepository->findListByIdUserId($list_id, $user->id);
        if($list==null){
            return response()->json(
                Response::_403_forbidden_()
            );
        }
        $this->_postListRepository->deleteById($list_id);
        return response()->json(
            Response::_204_no_content_('list deleted successfully')
        );
    }
    public function findById($list_id, User $user){
        $exist_list = $this->_postListRepository->findById($list_id);
        if($exist_list==null){
            return response()->json(
                Response::_404_not_found_('list not found')
            );            
        }
        $list = $this->_postListRepository
            ->findListByIdUserId($list_id, $user->id);
        if($list==null){
            return response()->json(
                Response::_403_forbidden_()
            );
        }
        return response()->json(
            Response::_200_success_('list found successfully', $list)
        );
    }
    public function userLists(User $user){
        $lists = $this->_postListRepository->findUserLists($user->id);
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
                $list = $this->_postListRepository->findById($value);
                if($list==null){
                    $fail('list not found');
                }
            }],
            'name'=>['required','unique:posts_lists'],
        ]);
        return CheckValidation::check_validation($validator);
    }

}
