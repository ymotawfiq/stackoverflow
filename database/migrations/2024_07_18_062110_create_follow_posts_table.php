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
        Schema::dropIfExists('follow_posts');
        Schema::create('follow_posts', function (Blueprint $table) {
            $table->string('post_id');
            $table->string('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('RESTRICT');
            $table->foreign('post_id')
                ->references('id')
                ->on('posts')
                ->onDelete('RESTRICT');
            $table->primary(['user_id','post_id']);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('follow_posts', function(Blueprint $table){
            $table->dropForeign('follow_posts_post_id_foreign');
            $table->dropForeign('follow_posts_user_id_foreign');
        });
        Schema::dropIfExists('follow_posts');
    }
};
