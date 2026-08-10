<?php

namespace Database\Seeders;

use App\Enums\BranchApplicationStatus;
use App\Models\BranchApplication;
use Illuminate\Database\Seeder;

class BranchApplicationSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            ['director_name' => 'Mohammad Arif', 'father_name' => 'Abdul Karim', 'mother_name' => 'Rokeya Begum', 'institute_name' => 'BNYTI Chattogram Branch', 'full_address' => 'Panchlaish, Chattogram', 'district' => 'Chattogram', 'upazila' => 'Panchlaish', 'post_office' => 'Chattogram GPO', 'email' => 'arif@example.test', 'sex' => 'Male', 'username' => 'arif_branch', 'password' => 'password', 'mobile_number' => '01730000001', 'status' => BranchApplicationStatus::Pending],
            ['director_name' => 'Branch User', 'father_name' => 'Nurul Islam', 'mother_name' => 'Shirin Akter', 'institute_name' => 'BNYTI Rajshahi Branch', 'full_address' => 'Boalia, Rajshahi', 'district' => 'Rajshahi', 'upazila' => 'Boalia', 'post_office' => 'Rajshahi GPO', 'email' => 'branch@bnyti.test', 'sex' => 'Female', 'username' => 'shamima_branch', 'password' => 'password', 'mobile_number' => '01730000002', 'status' => BranchApplicationStatus::Approved, 'reviewed_at' => now()],
        ] as $application) {
            BranchApplication::query()->updateOrCreate(['username' => $application['username']], $application);
        }
    }
}
