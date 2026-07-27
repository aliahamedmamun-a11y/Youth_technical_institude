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
        Schema::create('branch_applications', function (Blueprint $table): void {
            $table->id();
            $table->string('proposed_branch_name');
            $table->string('applicant_name');
            $table->string('email');
            $table->string('phone', 30);
            $table->string('district')->index();
            $table->text('address');
            $table->unsignedSmallInteger('years_of_experience')->nullable();
            $table->text('message')->nullable();
            $table->string('status')->default('pending')->index();
            $table->text('rejection_reason')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branch_applications');
    }
};
