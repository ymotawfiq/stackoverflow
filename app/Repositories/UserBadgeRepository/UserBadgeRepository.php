<?php

namespace App\Repositories\UserBadgeRepository;

use Illuminate\Support\Facades\DB;

class UserBadgeRepository implements UserBadgeRepositoryInterface
{
    public function create($data){
        DB::table('user_badges')->insert($data);
        return [
            'user_id'=>$data['user_id'],
            'badge'=>DB::table('badges')->where(['id'=>$data['badge_id']])->get()->first()
        ];
    }
    public function isUserHasBadge($data){
        return DB::table('user_badges')->where([
            'badge_id'=>$data['badge_id'],
            'user_id'=>$data['user_id']
            ])->get()->first();
    }
    public function removeBadgeFromUser($data){
        DB::table('user_badges')->where([
            'badge_id'=>$data['badge_id'],
            'user_id'=>$data['user_id']
            ])->delete();
    }
    public function all(){
        return DB::table('user_badges')->get();
    }

    public function getUserBadges($user_id){
        return DB::table('user_badges')->where(['user_id'=>$user_id])->get();
    }
}
