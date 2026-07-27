<?php

namespace App\Enums;

enum UserRole: string
{
    case SuperAdmin = 'super_admin';
    case Branch = 'branch';
    case Editor = 'editor';
    case Student = 'student';

    public function label(): string
    {
        return match ($this) {
            self::SuperAdmin => 'Super Admin',
            self::Branch => 'Branch',
            self::Editor => 'Editor',
            self::Student => 'Student',
        };
    }

    public function dashboardRoute(): string
    {
        return match ($this) {
            self::SuperAdmin => 'dashboards.super-admin',
            self::Branch => 'dashboards.branch',
            self::Editor => 'dashboards.editor',
            self::Student => 'dashboards.student',
        };
    }
}
