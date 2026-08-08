<?php

namespace Database\Seeders;

use App\Models\HomepageItem;
use App\Models\HomepageSection;
use Illuminate\Database\Seeder;

class HomepageItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sections = HomepageSection::query()->pluck('id', 'key');

        $items = [
            'hero' => [
                ['key' => 'hero-lab', 'title' => 'Practical skills for a future without limits.', 'subtitle' => 'Bangladesh National Youth Technical Institute', 'body' => 'Industry-focused technical training, experienced mentors, and nationwide opportunity—designed to turn ambition into employable expertise.', 'image' => 'images/bnyti-hero-premium-1.png', 'link_label' => 'Get Started', 'link_url' => '#courses'],
                ['key' => 'hero-workshop', 'title' => 'Build confidence through hands-on learning.', 'subtitle' => 'Bangladesh National Youth Technical Institute', 'body' => 'Modern laboratories and project-based classes help learners build skills they can use from day one.', 'image' => 'images/bnyti-hero-premium-2.png', 'link_label' => 'Explore Courses', 'link_url' => '#courses'],
                ['key' => 'hero-design', 'title' => 'Your next opportunity starts here.', 'subtitle' => 'Bangladesh National Youth Technical Institute', 'body' => 'Join a supportive technical education community and prepare for a changing world of work.', 'image' => 'images/bnyti-hero-premium-3.png', 'link_label' => 'Contact Us', 'link_url' => '#latest-news-contact'],
            ],
            'trust' => [
                ['key' => 'government-approved', 'title' => 'Government Approved', 'body' => 'Recognized by the Govt. of Bangladesh', 'icon' => 'government'],
                ['key' => 'practical-lab', 'title' => 'Practical Lab Training', 'body' => 'Hands-on training with modern tools', 'icon' => 'lab'],
                ['key' => 'expert-trainers', 'title' => 'Expert Trainers', 'body' => 'Experienced & industry-certified instructors', 'icon' => 'people'],
                ['key' => 'industry-partnership', 'title' => 'Industry Partnership', 'body' => 'Collaboration with leading industries', 'icon' => 'partnership'],
                ['key' => 'online-verification', 'title' => 'Online Verification', 'body' => 'Verify your certificate anytime, anywhere', 'icon' => 'verification'],
                ['key' => 'career-support', 'title' => 'Career Support', 'body' => 'Internship, placement & career guidance', 'icon' => 'career'],
            ],
            'statistics' => [
                ['key' => 'students', 'title' => '20,000+', 'subtitle' => 'Students Enrolled', 'icon' => 'students'],
                ['key' => 'branches', 'title' => '250+', 'subtitle' => 'Branches Across BD', 'icon' => 'branches'],
                ['key' => 'courses', 'title' => '80+', 'subtitle' => 'Courses Offered', 'icon' => 'courses'],
                ['key' => 'trainers', 'title' => '150+', 'subtitle' => 'Expert Trainers', 'icon' => 'trainers'],
                ['key' => 'satisfaction', 'title' => '98%', 'subtitle' => 'Student Satisfaction', 'icon' => 'satisfaction'],
                ['key' => 'employment', 'title' => '92%', 'subtitle' => 'Employment Success', 'icon' => 'employment'],
            ],
            'gallery' => array_map(fn (array $item): array => ['key' => $item[0], 'title' => $item[1], 'image' => $item[2], 'metadata' => ['panel' => $item[3]]], [
                ['smart-classroom', 'Smart Classroom', 'images/institute-gallery-1.png', 0], ['practical-lab', 'Practical Lab', 'images/institute-gallery-1.png', 1], ['computer-lab', 'Computer Lab', 'images/institute-gallery-1.png', 2], ['workshop', 'Workshop', 'images/institute-gallery-1.png', 3], ['seminar-hall', 'Seminar Hall', 'images/institute-gallery-2.png', 0], ['graduation', 'Graduation Ceremony', 'images/institute-gallery-2.png', 1], ['activities', 'Student Activities', 'images/institute-gallery-2.png', 2], ['campus', 'Campus View', 'images/institute-gallery-2.png', 3],
            ]),
            'testimonials' => [
                ['key' => 'riad-hasan', 'title' => 'Riad Hasan', 'subtitle' => 'Web Developer, Brain Station 23', 'body' => 'BNYTI helped me gain practical skills and confidence. Today, I am working as a Web Developer in a top IT firm.', 'image' => 'images/student-success-sprite.png'],
                ['key' => 'sadia-rahman', 'title' => 'Sadia Rahman', 'subtitle' => 'Graphic Designer, Creative IT', 'body' => 'The hands-on design training helped me build a strong portfolio and begin my career with confidence.', 'image' => 'images/student-success-sprite.png'],
                ['key' => 'mehedi-islam', 'title' => 'Mehedi Islam', 'subtitle' => 'Electrical Technician, Energypac', 'body' => 'Practical lab sessions prepared me for real technical work and helped me secure a rewarding position.', 'image' => 'images/student-success-sprite.png'],
                ['key' => 'nusrat-jahan', 'title' => 'Nusrat Jahan', 'subtitle' => 'Office Executive, Tech Solutions', 'body' => 'The instructors guided me from basic computer skills to a professional office career.', 'image' => 'images/student-success-sprite.png'],
            ],
            'branch-promotion' => [[
                'key' => 'main',
                'title' => 'APPLY AS A BRANCH ACROSS BANGLADESH',
                'subtitle' => 'Expand With BNYTI',
                'body' => 'Join our growing network of technical education and establish an authorized BNYTI branch in your district. Together, we can empower the next generation with quality skills and career opportunities.',
                'link_label' => 'Apply as a Branch',
                'link_url' => '/branch-application',
                'metadata' => [
                    'features' => ['Government Approved Training System', 'Complete Academic & Operational Support', 'Standard Curriculum & Learning Resources', 'Certificate Verification System', 'Marketing & Student Admission Support', 'Long-Term Institutional Partnership'],
                    'counters' => [['value' => '250+', 'label' => 'Branches'], ['value' => '64', 'label' => 'District Coverage'], ['value' => '20,000+', 'label' => 'Students'], ['value' => '150+', 'label' => 'Expert Trainers']],
                ],
            ]],
            'contact' => [[
                'key' => 'main',
                'title' => 'Contact Us',
                'body' => 'Haji Hossain Plaza, Demra Bazar Road, Dhaka-1360',
                'metadata' => ['phone' => '+880 9696-481628', 'email' => 'bnyti-edubd@gmail.com', 'map_url' => 'https://maps.google.com/?q=Haji+Hossain+Plaza+Demra+Dhaka'],
            ]],
            'footer' => [[
                'key' => 'main',
                'title' => 'Skills Today, Success Tomorrow',
                'body' => 'Made with love for Youth Empowerment',
                'metadata' => ['copyright' => '© 2026 Bangladesh National Youth Technical Institute. All rights reserved.'],
            ]],
        ];

        foreach ($items as $sectionKey => $sectionItems) {
            foreach ($sectionItems as $order => $item) {
                HomepageItem::query()->updateOrCreate(
                    ['homepage_section_id' => $sections[$sectionKey], 'stable_key' => $item['key']],
                    ['title' => $item['title'] ?? null, 'subtitle' => $item['subtitle'] ?? null, 'body' => $item['body'] ?? null, 'image_path' => $item['image'] ?? null, 'icon' => $item['icon'] ?? null, 'link_label' => $item['link_label'] ?? null, 'link_url' => $item['link_url'] ?? null, 'metadata' => $item['metadata'] ?? [], 'sort_order' => $order, 'is_published' => true],
                );
            }
        }
    }
}
