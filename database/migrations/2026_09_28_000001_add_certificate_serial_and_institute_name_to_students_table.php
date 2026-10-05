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
            if (! Schema::hasColumn('students', 'certificate_serial')) {
                $table->string('certificate_serial')->nullable()->after('roll_number');
            }
            if (! Schema::hasColumn('students', 'institute_name')) {
                $table->string('institute_name')->nullable()->after('director_name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table): void {
            $columns = [];
            if (Schema::hasColumn('students', 'certificate_serial')) {
                $columns[] = 'certificate_serial';
            }
            if (Schema::hasColumn('students', 'institute_name')) {
                $columns[] = 'institute_name';
            }
            if (! empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
};
