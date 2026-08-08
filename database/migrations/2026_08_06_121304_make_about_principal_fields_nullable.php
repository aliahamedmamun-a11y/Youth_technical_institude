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
        Schema::table('institute_profiles', function (Blueprint $table): void {
            $table->string('principal_name')->nullable()->change();
            $table->string('principal_title')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('institute_profiles', function (Blueprint $table): void {
            $table->string('principal_name')->nullable(false)->change();
            $table->string('principal_title')->default('Principal')->nullable(false)->change();
        });
    }
};
