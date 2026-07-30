<?php

namespace App\Models;

use App\Enums\BranchApplicationStatus;
use Database\Factories\BranchApplicationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchApplication extends Model
{
    /** @use HasFactory<BranchApplicationFactory> */
    use HasFactory;

    /** @var list<string> */
    protected $fillable = ['director_name', 'father_name', 'mother_name', 'institute_name', 'full_address', 'district', 'upazila', 'post_office', 'email', 'sex', 'username', 'password', 'mobile_number', 'director_signature_path', 'nid_photo_path', 'director_photo_path', 'status', 'rejection_reason', 'reviewed_at'];

    protected $hidden = ['password'];

    protected function casts(): array
    {
        return ['status' => BranchApplicationStatus::class, 'reviewed_at' => 'datetime', 'password' => 'hashed'];
    }
}
