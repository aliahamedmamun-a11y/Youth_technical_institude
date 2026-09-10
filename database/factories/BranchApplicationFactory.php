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
        return ['director_name' => fake()->name(), 'father_name' => fake()->name(), 'mother_name' => fake()->name(), 'institute_name' => fake()->city().' Technical Institute', 'full_address' => fake()->address(), 'district' => fake()->city(), 'upazila' => fake()->city(), 'post_office' => fake()->city().' Post Office', 'email' => fake()->unique()->safeEmail(), 'sex' => fake()->randomElement(['Male', 'Female']), 'username' => fake()->unique()->userName(), 'password' => 'password', 'mobile_number' => fake()->numerify('01#########'), 'status' => BranchApplicationStatus::Pending, 'director_photo_path' => 'branch-applications/directors/placeholder.jpg', 'institute_photo_path' => 'branch-applications/institutes/placeholder.jpg', 'nid_photo_path' => 'branch-applications/nid/placeholder.jpg', 'director_signature_path' => 'branch-applications/signatures/placeholder.jpg'];
    }

    public function approved(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => BranchApplicationStatus::Approved,
            'reviewed_at' => now(),
        ]);
    }
}
