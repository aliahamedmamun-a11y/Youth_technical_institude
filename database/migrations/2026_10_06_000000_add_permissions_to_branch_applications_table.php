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
        Schema::table('branch_applications', function (Blueprint $table) {
            $table->boolean('allow_certificate')->default(true)->after('is_active');
            $table->boolean('allow_testimonial')->default(true)->after('allow_certificate');
            $table->boolean('allow_transcript')->default(true)->after('allow_testimonial');
            $table->boolean('allow_result_publish')->default(true)->after('allow_transcript');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('branch_applications', function (Blueprint $table) {
            $table->dropColumn([
                'allow_certificate',
                'allow_testimonial',
                'allow_transcript',
                'allow_result_publish',
            ]);
        });
    }
};
