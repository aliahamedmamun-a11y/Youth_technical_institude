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
            $table->string('director_name')->nullable()->after('id');
            $table->string('father_name')->nullable()->after('director_name');
            $table->string('mother_name')->nullable()->after('father_name');
            $table->string('institute_name')->nullable()->after('mother_name');
            $table->text('full_address')->nullable()->after('institute_name');
            $table->string('upazila')->nullable()->after('district');
            $table->string('post_office')->nullable()->after('upazila');
            $table->string('sex', 20)->nullable()->after('email');
            $table->string('username')->nullable()->unique()->after('sex');
            $table->string('password')->nullable()->after('username');
            $table->string('mobile_number', 30)->nullable()->after('password');
            $table->string('director_signature_path')->nullable()->after('mobile_number');
            $table->string('nid_photo_path')->nullable()->after('director_signature_path');
            $table->string('director_photo_path')->nullable()->after('nid_photo_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('branch_applications', function (Blueprint $table): void {
            $table->dropUnique(['username']);
            $table->dropColumn(['director_name', 'father_name', 'mother_name', 'institute_name', 'full_address', 'upazila', 'post_office', 'sex', 'username', 'password', 'mobile_number', 'director_signature_path', 'nid_photo_path', 'director_photo_path']);
        });
    }
};
