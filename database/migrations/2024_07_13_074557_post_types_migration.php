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

        Schema::dropIfExists('post_types');
        Schema::create("post_types", function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('type')->nullable(false)->unique();
            $table->string('normalized_type')->nullable(false)->unique();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(Schema::hasTable('posts')){
            $foreign_keys = Schema::getForeignKeys('posts');
            if(in_array('posts_post_type_id_foreign', $foreign_keys)){
                Schema::table('posts', function (Blueprint $table) {
                    $table->dropForeign('posts_post_type_id_foreign');
                });
            }
        }
        if(Schema::hasTable('follow_posts')){
            $foreign_keys = Schema::getForeignKeys('follow_posts');
            if(in_array('follow_posts_post_id_foreign', $foreign_keys)){
                Schema::table('posts', function (Blueprint $table) {
                    $table->dropForeign('follow_posts_post_id_foreign');
                });
            }
        }
        Schema::dropIfExists('post_types');
    }
};
