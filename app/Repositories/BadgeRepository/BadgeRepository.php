<?php

namespace App\Repositories\BadgeRepository;

use Illuminate\Support\Facades\DB;

class BadgeRepository implements BadgeRepositoryInterface
{
    public function create($data){
        DB::table('badges')->insert($data);
        return $this->find_by_id($data['id']);
    }
    public function update($data){
        DB::table('badges')->where('id', $data->id)->update([
            'name'=>$data->name,
            'normalized_name'=>strtoupper($data->name)
        ]);
        return $this->find_by_id($data->id);
    }
    public function delete_by_id($id){
        DB::table('badges')->where('id', $id)->delete();
    }
    public function find_by_id($id){
        return DB::table('badges')->where('id', $id)->get()->first();
    }
    public function find_by_normalized_name(string $normalized_name){
        return DB::table('badges')
                ->where('normalized_type', strtoupper($normalized_name))->get()->first();
    }
    public function all(){
        return DB::table('badges')->get();
    }
}
