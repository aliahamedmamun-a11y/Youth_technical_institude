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
        Schema::create('institute_profiles', function (Blueprint $table): void {
            $table->id();
            $table->string('about_heading');
            $table->text('content');
            $table->string('principal_name');
            $table->string('principal_title')->default('Principal');
            $table->string('principal_image_path')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('institute_profiles');
    }
};
