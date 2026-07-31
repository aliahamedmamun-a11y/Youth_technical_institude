<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AcademicStructureSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function (): void {
            foreach ($this->structures() as $structure) {
                $department = Course::query()->where('name', $structure['department'])->firstOrFail();

                foreach ($structure['semesters'] as $semesterData) {
                    $semester = $department->semesters()->updateOrCreate(
                        ['name' => $semesterData['name']],
                        ['sort_order' => $semesterData['sort_order'], 'is_active' => true],
                    );

                    foreach ($semesterData['subjects'] as $sortOrder => $subjectData) {
                        $semester->subjects()->updateOrCreate(
                            ['code' => $subjectData['code']],
                            [...$subjectData, 'sort_order' => $sortOrder, 'is_active' => true],
                        );
                    }
                }
            }
        });
    }

    /**
     * @return list<array{department: string, semesters: list<array{name: string, sort_order: int, subjects: list<array{code: string, title: string, credit: int}>}>}>
     */
    private function structures(): array
    {
        return [
            [
                'department' => 'Computer Office Applications',
                'semesters' => [
                    ['name' => 'First Semester', 'sort_order' => 1, 'subjects' => [
                        ['code' => 'COA-101', 'title' => 'Computer Fundamentals', 'credit' => 4],
                        ['code' => 'COA-102', 'title' => 'Office Applications', 'credit' => 4],
                        ['code' => 'COA-103', 'title' => 'Typing and Documentation', 'credit' => 3],
                        ['code' => 'COA-104', 'title' => 'Communication Skills', 'credit' => 3],
                    ]],
                    ['name' => 'Second Semester', 'sort_order' => 2, 'subjects' => [
                        ['code' => 'COA-201', 'title' => 'Advanced Word Processing', 'credit' => 4],
                        ['code' => 'COA-202', 'title' => 'Spreadsheet and Data Analysis', 'credit' => 4],
                        ['code' => 'COA-203', 'title' => 'Presentation Design', 'credit' => 3],
                        ['code' => 'COA-204', 'title' => 'Internet and Digital Communication', 'credit' => 3],
                    ]],
                ],
            ],
            [
                'department' => 'Graphic Design and Multimedia',
                'semesters' => [
                    ['name' => 'First Semester', 'sort_order' => 1, 'subjects' => [
                        ['code' => 'GDM-101', 'title' => 'Design Fundamentals', 'credit' => 4],
                        ['code' => 'GDM-102', 'title' => 'Drawing and Visual Composition', 'credit' => 4],
                        ['code' => 'GDM-103', 'title' => 'Typography and Colour Theory', 'credit' => 3],
                        ['code' => 'GDM-104', 'title' => 'Computer Graphics Basics', 'credit' => 3],
                    ]],
                    ['name' => 'Second Semester', 'sort_order' => 2, 'subjects' => [
                        ['code' => 'GDM-201', 'title' => 'Digital Illustration', 'credit' => 4],
                        ['code' => 'GDM-202', 'title' => 'Image Editing and Retouching', 'credit' => 4],
                        ['code' => 'GDM-203', 'title' => 'Layout and Publication Design', 'credit' => 3],
                        ['code' => 'GDM-204', 'title' => 'Portfolio and Client Presentation', 'credit' => 3],
                    ]],
                ],
            ],
            [
                'department' => 'Electrical Installation and Maintenance',
                'semesters' => [
                    ['name' => 'First Semester', 'sort_order' => 1, 'subjects' => [
                        ['code' => 'EIM-101', 'title' => 'Electrical Fundamentals', 'credit' => 4],
                        ['code' => 'EIM-102', 'title' => 'Electrical Safety and Practice', 'credit' => 4],
                        ['code' => 'EIM-103', 'title' => 'Wiring Methods', 'credit' => 3],
                        ['code' => 'EIM-104', 'title' => 'Workshop Mathematics', 'credit' => 3],
                    ]],
                    ['name' => 'Second Semester', 'sort_order' => 2, 'subjects' => [
                        ['code' => 'EIM-201', 'title' => 'Domestic Installation', 'credit' => 4],
                        ['code' => 'EIM-202', 'title' => 'Industrial Wiring', 'credit' => 4],
                        ['code' => 'EIM-203', 'title' => 'Motors and Control Systems', 'credit' => 3],
                        ['code' => 'EIM-204', 'title' => 'Maintenance and Fault Finding', 'credit' => 3],
                    ]],
                ],
            ],
        ];
    }
}
