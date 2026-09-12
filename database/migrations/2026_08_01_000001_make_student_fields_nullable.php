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
        Schema::table('students', function (Blueprint $table): void {
            $table->foreignId('course_id')->nullable()->change();
            $table->string('name')->nullable()->change();
            $table->string('father_name')->nullable()->change();
            $table->string('mother_name')->nullable()->change();
            $table->text('address')->nullable()->change();
            $table->string('district')->nullable()->change();
            $table->string('upazila')->nullable()->change();
            $table->date('date_of_birth')->nullable()->change();
            $table->string('passport_nid_number')->nullable()->change();
            $table->string('phone')->nullable()->change();
            $table->string('gender')->nullable()->change();
            $table->string('end_month')->nullable()->change();
            $table->string('end_year')->nullable()->change();
            $table->string('education_qualification')->nullable()->change();
            $table->string('duration')->nullable()->change();
            $table->string('session')->nullable()->change();
            $table->date('admitted_at')->nullable()->change();
            $table->date('expire_date')->nullable()->change();
            $table->string('image_path')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverting to not-null is complex if data is already null.
    }
};
