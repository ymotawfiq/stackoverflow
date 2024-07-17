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
        if(Schema::hasColumn('posts', 'posts_post_type_id_foreign')){
            Schema::table('posts', function (Blueprint $table) {
                $table->dropForeign('posts_post_type_id_foreign');
            });
        }

        // Schema::table('posts', function (Blueprint $table) {
        //     $table->dropForeign('posts_post_type_id_foreign');
        // });
        Schema::dropIfExists('post_types');
    }
};
