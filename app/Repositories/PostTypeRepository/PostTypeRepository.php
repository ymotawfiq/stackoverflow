<?php

namespace App\Repositories\PostTypeRepository;

use Illuminate\Support\Facades\DB;

class PostTypeRepository implements PostTypeRepositoryInterface
{

    public function create($data){
        DB::table('post_types')->insert($data);
        return $this->findById($data['id']);
    }
    public function all(){
        return DB::table('post_types')->get();
    }
    public function deleteById($id){
        DB::table('post_types')->where('id', $id)->delete();
    }
    public function findById($id){
        return DB::table('post_types')->where('id', $id)->get()->first();
    }
    public function update($data){
        DB::table('post_types')->where('id', $data->id)->update([
            'type'=>$data->type,
            'normalized_type'=>strtoupper($data->type),
        ]);
        return $this->findById($data->id);
    }
    public function findByNormalizedType($normalized_type){
        return DB::table('post_types')->where('normalized_type', strtoupper($normalized_type))->get()->first();
    }
}
