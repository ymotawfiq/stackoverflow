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
    public function delete_by_id($id){
        DB::table('vote_type')->where('id', $id)->delete();
    }
    public function find_by_id($id){
        return DB::table('vote_type')->where('id', $id)->get()->first();
    }
    public function update($data){
        DB::table('vote_type')->where('id', $data->id)->update([
            'type'=>$data->type,
            'normalized_type'=>strtoupper($data->type),
        ]);
        return $this->find_by_id($data['id']);
    }
    public function find_by_normalized_type($normalized_type){
        return DB::table('vote_type')->where('normalized_type', strtoupper($normalized_type))->get()->first();
    }
}
