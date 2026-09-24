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
            if (! Schema::hasColumn('students', 'branch_id')) {
                $table->string('branch_id')->nullable()->after('id');
            }
            if (! Schema::hasColumn('students', 'director_name')) {
                $table->string('director_name')->nullable()->after('expire_date');
            }
            if (! Schema::hasColumn('students', 'full_marks')) {
                $table->integer('full_marks')->nullable()->default(1200);
            }
            if (! Schema::hasColumn('students', 'written_marks')) {
                $table->decimal('written_marks', 8, 2)->nullable();
            }
            if (! Schema::hasColumn('students', 'viva_marks')) {
                $table->decimal('viva_marks', 8, 2)->nullable();
            }
            if (! Schema::hasColumn('students', 'practical_marks')) {
                $table->decimal('practical_marks', 8, 2)->nullable();
            }
            if (! Schema::hasColumn('students', 'cgpa')) {
                $table->decimal('cgpa', 4, 2)->nullable();
            }
            if (! Schema::hasColumn('students', 'publication_date')) {
                $table->string('publication_date')->nullable();
            }
            if (! Schema::hasColumn('students', 'examination_month')) {
                $table->string('examination_month')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table): void {
            $table->dropColumn([
                'branch_id',
                'director_name',
                'full_marks',
                'written_marks',
                'viva_marks',
                'practical_marks',
                'cgpa',
                'publication_date',
                'examination_month',
            ]);
        });
    }
};
