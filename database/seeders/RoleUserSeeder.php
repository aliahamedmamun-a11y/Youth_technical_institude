<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->users() as $user) {
            User::query()->updateOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'role' => $user['role']->value,
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                ],
            );
        }
    }

    /**
     * @return array<int, array{name: string, email: string, role: UserRole}>
     */
    private function users(): array
    {
        return [
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@bnyti.test',
                'role' => UserRole::SuperAdmin,
            ],
            [
                'name' => 'Branch User',
                'email' => 'branch@bnyti.test',
                'role' => UserRole::Branch,
            ],
            [
                'name' => 'Certificate Editor',
                'email' => 'editor@bnyti.test',
                'role' => UserRole::Editor,
            ],
            [
                'name' => 'Student User',
                'email' => 'student@bnyti.test',
                'role' => UserRole::Student,
            ],
        ];
    }
}
