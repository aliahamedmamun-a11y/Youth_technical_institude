<?php

namespace Database\Seeders;

use App\Models\InstituteProfile;
use Illuminate\Database\Seeder;

class InstituteProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        InstituteProfile::query()->updateOrCreate(
            ['id' => 1],
            [
                'about_heading' => 'Education that moves beyond the classroom.',
                'slug' => 'education-that-moves-beyond-the-classroom',
                'summary' => 'BNYTI combines practical training, professional ethics, and modern technical education for Bangladesh’s youth.',
                'content' => "Bangladesh National Youth Technical Institute (BNYTI) is a renowned technical and skills development institution in Bangladesh, committed to empowering the nation's youth with industry-relevant knowledge, practical expertise, and modern technological skills.\n\nBNYTI provides a comprehensive learning environment that combines theoretical knowledge with hands-on training, professional ethics, and practical experience. Our goal is to equip every learner with the confidence and competence required to succeed in today's competitive world.\n\nThrough years of excellence and dedication, the institute has expanded its educational services across Bangladesh. Our growing branch network continues to deliver accessible, quality technical education and skills development training to students and trainees.",
                'principal_name' => 'Mst Salma Rahman',
                'principal_title' => 'Principal',
                'principal_image_path' => 'images/principal-portrait.webp',
                'image_path' => null,
                'sort_order' => 1,
                'is_published' => true,
                'is_active' => true,
            ],
        );

        $entries = [
            [
                'id' => 2,
                'about_heading' => 'Practical skills for a changing world.',
                'slug' => 'practical-skills-for-a-changing-world',
                'summary' => 'Learn by doing with modern labs, supportive mentors, and career-focused training.',
                'content' => 'Our practical learning model turns classroom concepts into confident, job-ready skills. Students work with modern tools, complete real projects, and receive guidance from experienced instructors throughout their journey.',
                'principal_name' => 'Engr. Md. Rasel',
                'principal_title' => 'Head of Technical Training',
                'principal_image_path' => 'images/principal-portrait.webp',
                'image_path' => 'images/institute-gallery-1.png',
                'sort_order' => 2,
                'is_published' => true,
                'is_active' => true,
            ],
            [
                'id' => 3,
                'about_heading' => 'Building confidence through opportunity.',
                'slug' => 'building-confidence-through-opportunity',
                'summary' => 'BNYTI connects technical education with meaningful opportunities for young people.',
                'content' => 'We believe every learner deserves access to quality technical education. Our courses combine fundamentals, hands-on practice, and professional development so students can take their next step with confidence.',
                'principal_name' => 'Farhana Akter',
                'principal_title' => 'Academic Coordinator',
                'principal_image_path' => 'images/principal-portrait.webp',
                'image_path' => 'images/institute-gallery-2.png',
                'sort_order' => 3,
                'is_published' => true,
                'is_active' => true,
            ],
            [
                'id' => 4,
                'about_heading' => 'A community committed to excellence.',
                'slug' => 'a-community-committed-to-excellence',
                'summary' => 'Join a growing institute community focused on discipline, innovation, and lifelong learning.',
                'content' => 'From our classrooms and laboratories to our expanding branch network, BNYTI is creating a welcoming environment where students can learn, collaborate, and prepare for a successful future.',
                'principal_name' => 'Jamal Hasan',
                'principal_title' => 'Student Development Officer',
                'principal_image_path' => 'images/principal-portrait.webp',
                'image_path' => 'images/bnyti-hero-premium-2.png',
                'sort_order' => 4,
                'is_published' => true,
                'is_active' => true,
            ],
        ];

        foreach ($entries as $entry) {
            $id = $entry['id'];
            unset($entry['id']);

            InstituteProfile::query()->updateOrCreate(['id' => $id], $entry);
        }
    }
}
