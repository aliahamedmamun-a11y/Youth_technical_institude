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
            $table->string('proposed_branch_name')->nullable()->change();
            $table->string('applicant_name')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->string('phone', 30)->nullable()->change();
            $table->string('district')->nullable()->change();
            $table->text('address')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('branch_applications', function (Blueprint $table): void {
            $table->string('proposed_branch_name')->nullable(false)->change();
            $table->string('applicant_name')->nullable(false)->change();
            $table->string('email')->nullable(false)->change();
            $table->string('phone', 30)->nullable(false)->change();
            $table->string('district')->nullable(false)->change();
            $table->text('address')->nullable(false)->change();
        });
    }
};
