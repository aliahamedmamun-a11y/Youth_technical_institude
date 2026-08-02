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
        Schema::table('student_result_subjects', function (Blueprint $table): void {
            $table->string('grade', 10)->nullable()->change();
            $table->decimal('grade_point', 4, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_result_subjects', function (Blueprint $table): void {
            $table->string('grade', 10)->nullable(false)->change();
            $table->decimal('grade_point', 4, 2)->nullable(false)->change();
        });
    }
};
