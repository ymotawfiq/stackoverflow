<?php

namespace App\Repositories\PostHistoryTypesRepository;

use Illuminate\Support\Facades\DB;

class PostHistoryTypesRepository implements PostHistoryTypesRepositoryInterface
{
    public function create($data){
        DB::table('post_history_types')->insert($data);
        return $this->find_by_id($data['id']);
    }
    public function all(){
        return DB::table('post_history_types')->get();
    }
    public function delete_by_id($id){
        DB::table('post_history_types')->where('id', $id)->delete();
    }
    public function find_by_id($id){
        return DB::table('post_history_types')->where('id', $id)->get()->first();
    }
    public function update($data){
        DB::table('post_history_types')->where('id', $data->id)->update([
            'type'=>$data->type,
            'normalized_type'=>strtoupper($data->type),
        ]);
        return $this->find_by_id($data->id);
    }
    public function find_by_normalized_type($normalized_type){
        return DB::table('post_history_types')
            ->where('normalized_type', strtoupper($normalized_type))->get()->first();
    }
}
