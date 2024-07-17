<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            [
                'name'=>'ADMIN',
                'id'=>Uuid::uuid4()->toString(),
                'guard_name'=>'api',
                'created_at'=>now(),
                'updated_at'=>now()
            ], [
                'name'=>'USER',
                'id'=>Uuid::uuid4()->toString(),
                'guard_name'=>'api',
                'created_at'=>now(),
                'updated_at'=>now()
            ]]);
    }
}
