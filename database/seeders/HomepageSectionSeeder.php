<?php

namespace Database\Seeders;

use App\Models\HomepageSection;
use Illuminate\Database\Seeder;

class HomepageSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ([
            ['key' => 'top-banner', 'label' => 'Top Banner', 'sort_order' => 0],
            ['key' => 'hero', 'label' => 'Hero Slides', 'sort_order' => 1],
            ['key' => 'notice-bar', 'label' => 'Notices', 'sort_order' => 2],
            ['key' => 'trust', 'label' => 'Trust Indicators', 'sort_order' => 3],
            ['key' => 'about', 'label' => 'About Us', 'sort_order' => 4],
            ['key' => 'statistics', 'label' => 'Achievement Statistics', 'sort_order' => 5],
            ['key' => 'courses', 'label' => 'Popular Courses', 'sort_order' => 6],
            ['key' => 'teachers', 'label' => 'Expert Teachers', 'sort_order' => 7],
            ['key' => 'branch-promotion', 'label' => 'Branch Promotion', 'sort_order' => 8],
            ['key' => 'gallery', 'label' => 'Institute Gallery', 'sort_order' => 9],
            ['key' => 'testimonials', 'label' => 'Student Testimonials', 'sort_order' => 10],
            ['key' => 'news', 'label' => 'News & Announcements', 'sort_order' => 11],
            ['key' => 'contact', 'label' => 'Contact Information', 'sort_order' => 12],
            ['key' => 'footer', 'label' => 'Footer Settings', 'sort_order' => 13],
        ] as $section) {
            HomepageSection::query()->updateOrCreate(['key' => $section['key']], $section + ['is_visible' => true]);
        }
    }
}
