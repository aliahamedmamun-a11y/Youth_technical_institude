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
        Schema::create('student_result_subjects', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('student_result_id')->constrained()->cascadeOnDelete();
            $table->string('code', 30);
            $table->string('title');
            $table->decimal('credit', 5, 2);
            $table->decimal('marks', 5, 2)->nullable();
            $table->string('grade', 10);
            $table->decimal('grade_point', 4, 2);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
            $table->unique(['student_result_id', 'code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_result_subjects');
    }
};
