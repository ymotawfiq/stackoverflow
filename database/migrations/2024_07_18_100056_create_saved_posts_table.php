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
        Schema::dropIfExists('saved_posts');
        Schema::create('saved_posts', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('post_id');
            $table->string('user_id');
            $table->string('list_id');
            $table->unique(['list_id','user_id', 'post_id']);
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('RESTRICT');
            $table->foreign('post_id')
                ->references('id')
                ->on('posts')
                ->onDelete('RESTRICT');
            $table->foreign('list_id')
                ->references('id')
                ->on('posts_lists')
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
        $foreign_keys = Schema::getForeignKeys('saved_posts');
        if(in_array('saved_posts_user_id_foreign', $foreign_keys)){
            Schema::table('saved_posts', function(Blueprint $table){
                $table->dropForeign(['saved_posts_user_id_foreign']);
            });
        }
        if(in_array('saved_posts_post_id_foreign', $foreign_keys)){
            Schema::table('saved_posts', function(Blueprint $table){
                $table->dropForeign(['saved_posts_post_id_foreign']);
            });
        }
        if(in_array('saved_posts_list_id_foreign', $foreign_keys)){
            Schema::table('saved_posts', function(Blueprint $table){
                $table->dropForeign(['saved_posts_list_id_foreign']);
            });
        }
        Schema::dropIfExists('saved_posts');
    }
};
