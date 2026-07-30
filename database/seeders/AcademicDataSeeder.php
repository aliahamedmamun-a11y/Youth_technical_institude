<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Database\Seeder;

class AcademicDataSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->courses() as $course) {
            Course::query()->updateOrCreate(['code' => $course['code']], $course);
        }

        foreach ($this->teachers() as $teacher) {
            Teacher::query()->updateOrCreate(['employee_number' => $teacher['employee_number']], $teacher);
        }

        $courses = Course::query()->pluck('id', 'code');

        foreach ($this->students() as $student) {
            $courseCode = $student['course_code'];
            unset($student['course_code']);

            Student::query()->updateOrCreate(
                ['registration_number' => $student['registration_number']],
                [...$student, 'course_id' => $courses[$courseCode]],
            );
        }
    }

    /** @return list<array{name: string, code: string, duration: string, description: string, is_active: bool}> */
    private function courses(): array
    {
        return [
            ['name' => 'Computer Office Applications', 'code' => 'COA-101', 'duration' => '6 Months', 'description' => 'Practical training in office productivity and computer fundamentals.', 'is_active' => true],
            ['name' => 'Graphic Design and Multimedia', 'code' => 'GDM-201', 'duration' => '6 Months', 'description' => 'Hands-on design, illustration, and multimedia production training.', 'is_active' => true],
            ['name' => 'Electrical Installation and Maintenance', 'code' => 'EIM-301', 'duration' => '1 Year', 'description' => 'Technical training in safe electrical installation and maintenance.', 'is_active' => true],
        ];
    }

    /** @return list<array{name: string, employee_number: string, email: string, phone: string, designation: string, department: string, qualification: string, image_path: string, joined_at: string, is_active: bool}> */
    private function teachers(): array
    {
        return [
            ['name' => 'Md. Rahim Uddin', 'employee_number' => 'T-1001', 'email' => 'rahim@bnyti.test', 'phone' => '01710000001', 'designation' => 'Senior Instructor', 'department' => 'Computer', 'qualification' => 'BSc in Computer Science', 'image_path' => 'teachers/md-rahim-uddin.png', 'joined_at' => '2022-01-10', 'is_active' => true],
            ['name' => 'Farhana Akter', 'employee_number' => 'T-1002', 'email' => 'farhana@bnyti.test', 'phone' => '01710000002', 'designation' => 'Instructor', 'department' => 'Design', 'qualification' => 'BFA in Graphic Design', 'image_path' => 'teachers/farhana-akter.png', 'joined_at' => '2023-03-15', 'is_active' => true],
            ['name' => 'Kamal Hossain', 'employee_number' => 'T-1003', 'email' => 'kamal@bnyti.test', 'phone' => '01710000003', 'designation' => 'Technical Instructor', 'department' => 'Electrical', 'qualification' => 'Diploma in Electrical Engineering', 'image_path' => 'teachers/kamal-hossain.png', 'joined_at' => '2021-07-01', 'is_active' => true],
        ];
    }

    /** @return list<array{course_code: string, name: string, registration_number: string, roll_number: string, father_name: string, mother_name: string, phone: string, email: string, gender: string, date_of_birth: string, address: string, admitted_at: string, result_status: string, grade: string, score: int}> */
    private function students(): array
    {
        return [
            ['course_code' => 'COA-101', 'name' => 'Ayesha Rahman', 'registration_number' => 'BNYTI-2026-001', 'roll_number' => '101', 'father_name' => 'Abdul Rahman', 'mother_name' => 'Salma Begum', 'phone' => '01720000001', 'email' => 'ayesha@bnyti.test', 'gender' => 'Female', 'date_of_birth' => '2005-06-14', 'address' => 'Mirpur, Dhaka', 'admitted_at' => '2026-01-05', 'result_status' => 'Passed', 'grade' => 'A+', 'score' => 91],
            ['course_code' => 'GDM-201', 'name' => 'Tanvir Hasan', 'registration_number' => 'BNYTI-2026-002', 'roll_number' => '202', 'father_name' => 'Jamal Hasan', 'mother_name' => 'Rina Akter', 'phone' => '01720000002', 'email' => 'tanvir@bnyti.test', 'gender' => 'Male', 'date_of_birth' => '2004-11-20', 'address' => 'Uttara, Dhaka', 'admitted_at' => '2026-01-07', 'result_status' => 'Passed', 'grade' => 'A', 'score' => 86],
            ['course_code' => 'EIM-301', 'name' => 'Nusrat Jahan', 'registration_number' => 'BNYTI-2026-003', 'roll_number' => '303', 'father_name' => 'Nurul Islam', 'mother_name' => 'Shirin Akter', 'phone' => '01720000003', 'email' => 'nusrat@bnyti.test', 'gender' => 'Female', 'date_of_birth' => '2005-02-08', 'address' => 'Savar, Dhaka', 'admitted_at' => '2026-01-10', 'result_status' => 'Pending', 'grade' => '', 'score' => 0],
        ];
    }
}
