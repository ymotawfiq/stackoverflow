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
        Schema::dropIfExists('users');
        Schema::create('users', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('display_name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('website_url')->nullable(true);
            $table->string('profile_image_url')->nullable(true);
            $table->string('location')->nullable(true);
            $table->string('about_me')->type('longtext')->nullable(true);
            $table->string('username')->unique()->nullable(false);
            $table->integer('views')->default(0);
            $table->integer('up_votes')->default(0);
            $table->integer('down_votes')->default(0);
            $table->timestamp('last_access_date')->default(now());
            $table->tinyInteger('is_two_factor_enabled')->default(0);
            $table->string('password');
            $table->rememberToken();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(Schema::hasTable('posts')){
            $foreign_keys = Schema::getForeignKeys('posts');
            if(in_array('posts_owner_id_foreign', $foreign_keys)){
                Schema::table('posts', function (Blueprint $table) {
                    $table->dropForeign('posts_owner_id_foreign');
                });
            }
        }        
        if(Schema::hasTable('follow_posts')){
            $foreign_keys = Schema::getForeignKeys('follow_posts');
            if(in_array('follow_posts_user_id_foreign', $foreign_keys)){
                Schema::table('posts', function (Blueprint $table) {
                    $table->dropForeign('follow_posts_user_id_foreign');
                });
            }
        }
        if(Schema::hasTable('posts_lists')){
            $foreign_keys = Schema::getForeignKeys('posts_lists');
            if(in_array('posts_lists_user_id_foreign', $foreign_keys)){
                Schema::table('posts_lists', function(Blueprint $table){
                    $table->dropForeign('posts_lists_user_id_foreign');
                });
            }
        }
        if(Schema::hasTable('saved_posts')){
            $foreign_keys = Schema::getForeignKeys('saved_posts');
            if(in_array('saved_posts_user_id_foreign', $foreign_keys)){
                Schema::table('saved_posts', function(Blueprint $table){
                    $table->dropForeign(['saved_posts_user_id_foreign']);
                });
            }
        }
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
