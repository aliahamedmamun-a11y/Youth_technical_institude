<?php

namespace Database\Seeders;

use App\Models\Notice;
use Illuminate\Database\Seeder;

class NoticeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ([
            ['title' => 'July 2026 admission is now open', 'message' => 'Apply now for practical, career-focused technical training.', 'minutes' => 1],
            ['title' => 'Branch applications are being accepted', 'message' => 'Contact the institute for branch partnership and application guidance.', 'minutes' => 2],
            ['title' => 'Student support is available', 'message' => 'Our team is ready to help with course counselling and registration.', 'minutes' => 3],
        ] as $item) {
            Notice::query()->updateOrCreate(
                ['title' => $item['title']],
                ['message' => $item['message'], 'published_at' => now()->subMinutes($item['minutes']), 'is_published' => true],
            );
        }
    }
}
