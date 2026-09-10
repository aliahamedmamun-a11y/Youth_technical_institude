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
            $table->string('institute_photo_path')->nullable()->after('director_photo_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('branch_applications', function (Blueprint $table) {
            $table->dropColumn('institute_photo_path');
        });
    }
};
