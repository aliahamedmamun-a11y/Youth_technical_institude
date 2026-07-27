<?php

namespace Database\Factories;

use App\Enums\BranchApplicationStatus;
use App\Models\BranchApplication;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BranchApplication>
 */
class BranchApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'proposed_branch_name' => fake()->city().' Technical Institute', 'applicant_name' => fake()->name(), 'email' => fake()->safeEmail(), 'phone' => fake()->numerify('01#########'), 'district' => fake()->city(), 'address' => fake()->address(), 'years_of_experience' => fake()->numberBetween(1, 15), 'message' => fake()->paragraph(), 'status' => BranchApplicationStatus::Pending,
        ];
    }
}
