<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\User;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $author = User::query()->where('email', 'superadmin@bnyti.test')->firstOrFail();

        foreach ([
            ['key' => 'july-admission', 'title' => 'July 2026 Admission Open', 'excerpt' => 'Applications are now open for the next technical training session.', 'content' => 'Applications are now open for the July 2026 session. Contact the institute for course counselling and admission support.'],
            ['key' => 'practical-training', 'title' => 'New Practical Training Schedule', 'excerpt' => 'Updated lab and workshop schedules are available for students.', 'content' => 'Students can now view the updated practical lab and workshop schedule through their department office.'],
            ['key' => 'career-support', 'title' => 'Career Support and Placement', 'excerpt' => 'Career guidance sessions are available for graduating students.', 'content' => 'Our career support team is arranging guidance, portfolio review, and placement preparation sessions.'],
            ['key' => 'result-portal', 'title' => 'Online Result Portal Available', 'excerpt' => 'Students can verify published semester results online.', 'content' => 'Use the public result portal with your roll number to view published semester results and verification details.'],
            ['key' => 'branch-applications', 'title' => 'Branch Applications Accepted', 'excerpt' => 'Training partners can submit branch applications nationwide.', 'content' => 'Qualified organizations may submit a branch application for partnership and institutional support.'],
        ] as $item) {
            $slug = $item['key'];
            unset($item['key']);
            News::query()->updateOrCreate(
                ['slug' => $slug],
                $item + ['created_by' => $author->id, 'image_path' => 'images/institute-gallery-1.png', 'published_at' => now(), 'is_published' => true],
            );
        }
    }
}
