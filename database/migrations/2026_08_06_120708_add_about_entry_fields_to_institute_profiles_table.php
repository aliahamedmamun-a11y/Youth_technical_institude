<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('institute_profiles', function (Blueprint $table): void {
            $table->string('slug')->nullable()->unique()->after('id');
            $table->string('summary')->nullable()->after('about_heading');
            $table->string('image_path')->nullable()->after('principal_image_path');
            $table->unsignedInteger('sort_order')->default(0)->index()->after('image_path');
            $table->boolean('is_published')->default(true)->index()->after('sort_order');
        });

        foreach (DB::table('institute_profiles')->get(['id', 'about_heading', 'content']) as $profile) {
            DB::table('institute_profiles')->where('id', $profile->id)->update([
                'slug' => Str::slug($profile->about_heading).'-'.$profile->id,
                'summary' => Str::limit($profile->content, 240),
                'sort_order' => $profile->id,
                'is_published' => true,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('institute_profiles', function (Blueprint $table): void {
            $table->dropUnique(['slug']);
            $table->dropColumn(['slug', 'summary', 'image_path', 'sort_order', 'is_published']);
        });
    }
};
