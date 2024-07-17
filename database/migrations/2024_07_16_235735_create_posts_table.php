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
        Schema::dropIfExists('posts');
        Schema::create('posts', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('owner_id')->nullable(false);
            $table->string('post_type_id')->nullable(false);
            $table->string('body');
            $table->string('title');
            $table->integer('comments')->default(0)->unsigned();
            $table->integer('answers')->default(0)->unsigned();
            $table->integer('tags')->default(0)->unsigned();
            $table->integer('views')->default(0)->unsigned();
            $table->tinyInteger('is_deleted')->default(0);
            $table->tinyInteger('is_discussion')->default(0);
            $table->foreign('owner_id')
                ->references('id')
                ->on('users')
                ->onDelete('RESTRICT');
            $table->foreign('post_type_id')
                ->references('id')
                ->on('post_types')
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
        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeign('posts_owner_id_foreign');
            $table->dropForeign('posts_post_type_id_foreign');
        });
        Schema::dropIfExists('posts');
    }
};
