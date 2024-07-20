<?php

namespace App\Repositories\BadgeRepository;

use Illuminate\Support\Facades\DB;

class BadgeRepository implements BadgeRepositoryInterface
{
    public function create($data){
        DB::table('badges')->insert($data);
        return $this->findById($data['id']);
    }
    public function update($data){
        DB::table('badges')->where('id', $data->id)->update([
            'name'=>$data->name,
            'normalized_name'=>strtoupper($data->name)
        ]);
        return $this->findById($data->id);
    }
    public function deleteById($id){
        DB::table('badges')->where('id', $id)->delete();
    }
    public function findById($id){
        return DB::table('badges')->where('id', $id)->get()->first();
    }
    public function findByNormalizedName(string $normalized_name){
        return DB::table('badges')
                ->where('normalized_type', strtoupper($normalized_name))->get()->first();
    }
    public function all(){
        return DB::table('badges')->get();
    }
}
