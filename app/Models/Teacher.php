<?php

namespace App\Models;

use Database\Factories\TeacherFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    /** @use HasFactory<TeacherFactory> */
    use HasFactory;

    /** @var list<string> */
    protected $fillable = ['name', 'employee_number', 'email', 'phone', 'designation', 'department', 'qualification', 'description', 'image_path', 'joined_at', 'is_active'];

    protected function casts(): array
    {
        return ['joined_at' => 'date', 'is_active' => 'boolean'];
    }
}
