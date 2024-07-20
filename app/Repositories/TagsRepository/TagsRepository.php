<?php

namespace App\Repositories\TagsRepository;

use Illuminate\Support\Facades\DB;

class TagsRepository implements TagsRepositoryInterface
{
    public function create($data){
        DB::table('tags')->insert($data);
        return $this->findById($data['id']);
    }
    public function all(){
        return DB::table('tags')->get();
    }
    public function deleteById($id){
        DB::table('tags')->where('id', $id)->delete();
    }
    public function findById($id){
        return DB::table('tags')->where('id', $id)->get()->first();
    }
    public function update($data){
        DB::table('tags')->where('id', $data->id)->update([
            'name'=>$data->name,
            'normalized_name'=>strtoupper($data->name),
        ]);
        return $this->findById($data->id);
    }
    public function findByNormalizedName($name){
        return DB::table('tags')->where('normalized_name', strtoupper($name))->get()->first();
    }
}
