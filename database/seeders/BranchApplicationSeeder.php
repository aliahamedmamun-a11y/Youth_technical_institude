<?php

namespace Database\Seeders;

use App\Enums\BranchApplicationStatus;
use App\Models\BranchApplication;
use Illuminate\Database\Seeder;

class BranchApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ([
            ['proposed_branch_name' => 'BNYTI Chattogram Branch', 'applicant_name' => 'Mohammad Arif', 'email' => 'arif@example.test', 'phone' => '01730000001', 'district' => 'Chattogram', 'address' => 'Panchlaish, Chattogram', 'years_of_experience' => 8, 'message' => 'We have suitable training facilities and an experienced local team.', 'status' => BranchApplicationStatus::Pending],
            ['proposed_branch_name' => 'BNYTI Rajshahi Branch', 'applicant_name' => 'Shamima Noor', 'email' => 'shamima@example.test', 'phone' => '01730000002', 'district' => 'Rajshahi', 'address' => 'Boalia, Rajshahi', 'years_of_experience' => 6, 'message' => 'We would like to expand technical education opportunities in Rajshahi.', 'status' => BranchApplicationStatus::Approved, 'reviewed_at' => now()],
        ] as $application) {
            BranchApplication::query()->updateOrCreate(['email' => $application['email']], $application);
        }
    }
}
