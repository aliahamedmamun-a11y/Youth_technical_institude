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
        Schema::table('branch_applications', function (Blueprint $table): void {
            $table->string('director_name')->nullable()->change();
            $table->string('father_name')->nullable()->change();
            $table->string('mother_name')->nullable()->change();
            $table->string('institute_name')->nullable()->change();
            $table->text('full_address')->nullable()->change();
            $table->string('district')->nullable()->change();
            $table->string('upazila')->nullable()->change();
            $table->string('post_office')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->string('sex')->nullable()->change();
            $table->string('mobile_number')->nullable()->change();
            $table->string('director_signature_path')->nullable()->change();
            $table->string('nid_photo_path')->nullable()->change();
            $table->string('director_photo_path')->nullable()->change();
            $table->string('institute_photo_path')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
