<?php

namespace Database\Factories;

use App\Enums\BranchApplicationStatus;
use App\Models\BranchApplication;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<BranchApplication> */
class BranchApplicationFactory extends Factory
{
    public function definition(): array
    {
        return ['director_name' => fake()->name(), 'father_name' => fake()->name(), 'mother_name' => fake()->name(), 'institute_name' => fake()->city().' Technical Institute', 'full_address' => fake()->address(), 'district' => fake()->city(), 'upazila' => fake()->city(), 'post_office' => fake()->city().' Post Office', 'email' => fake()->unique()->safeEmail(), 'sex' => fake()->randomElement(['Male', 'Female']), 'username' => fake()->unique()->userName(), 'password' => 'password', 'mobile_number' => fake()->numerify('01#########'), 'status' => BranchApplicationStatus::Pending];
    }
}
