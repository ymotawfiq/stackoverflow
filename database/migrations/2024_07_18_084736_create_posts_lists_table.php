<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('posts_lists');
        Schema::create('posts_lists', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name');
            $table->string('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('RESTRICT');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $foreign_keys = Schema::getForeignKeys('posts_lists');
        if(in_array('posts_lists_user_id_foreign', $foreign_keys)){
            Schema::table('posts_lists', function(Blueprint $table){
                $table->dropForeign('posts_lists_user_id_foreign');
            });
        }
        Schema::dropIfExists('posts_lists');
    }
};
