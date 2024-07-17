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
        Schema::create("badges", function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name')->nullable(false)->unique();
            $table->string('normalized_name')->nullable(false)->unique();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();  
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('badges');
    }
};
