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
        Schema::create('student_results', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->string('semester');
            $table->string('session', 100);
            $table->string('status', 20)->default('draft')->index();
            $table->string('verification_token', 64)->unique();
            $table->decimal('total_credit', 6, 2)->default(0);
            $table->decimal('credit_earned', 6, 2)->default(0);
            $table->decimal('gpa', 4, 2)->nullable();
            $table->string('overall_grade', 10)->nullable();
            $table->timestamp('published_at')->nullable()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_results');
    }
};
