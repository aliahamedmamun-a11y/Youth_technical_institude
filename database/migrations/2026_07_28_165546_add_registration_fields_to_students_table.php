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
            $table->string('registration_number')->nullable()->change();
            $table->string('district')->nullable()->after('address')->index();
            $table->string('upazila')->nullable()->after('district')->index();
            $table->string('passport_nid_number')->nullable()->after('upazila')->index();
            $table->string('education_qualification')->nullable()->after('passport_nid_number');
            $table->string('duration')->nullable()->after('education_qualification');
            $table->string('session')->nullable()->after('duration');
            $table->date('expire_date')->nullable()->after('admitted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table): void {
            $table->string('registration_number')->nullable(false)->change();
            $table->dropColumn(['district', 'upazila', 'passport_nid_number', 'education_qualification', 'duration', 'session', 'expire_date']);
        });
    }
};
