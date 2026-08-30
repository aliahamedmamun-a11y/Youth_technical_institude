<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->string('start_month')->nullable()->after('education_qualification');
            $table->string('end_month')->nullable()->after('start_month');
            $table->string('start_year')->nullable()->after('end_month');
            $table->string('end_year')->nullable()->after('start_year');
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn([
                'start_month',
                'end_month',
                'start_year',
                'end_year',
            ]);
        });
    }
};