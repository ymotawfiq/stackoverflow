<?php

namespace App\Repositories\VoteTypeRepository;

use Illuminate\Support\Facades\DB;

class VoteTypeRepository implements VoteTypeRepositoryInterface
{

    public function create($data){
        DB::table('vote_type')->insert($data);
        return $data;
    }
    public function all(){
        return DB::table('vote_type')->get();
    }
    public function deleteById($id){
        DB::table('vote_type')->where('id', $id)->delete();
    }
    public function findById($id){
        return DB::table('vote_type')->where('id', $id)->get()->first();
    }
    public function update($data){
        DB::table('vote_type')->where('id', $data->id)->update([
            'type'=>$data->type,
            'normalized_type'=>strtoupper($data->type),
        ]);
        return $this->findById($data['id']);
    }
    public function findByNormalizedType($normalized_type){
        return DB::table('vote_type')->where('normalized_type', strtoupper($normalized_type))->get()->first();
    }
}
