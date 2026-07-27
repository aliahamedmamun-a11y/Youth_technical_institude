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
    protected $fillable = ['proposed_branch_name', 'applicant_name', 'email', 'phone', 'district', 'address', 'years_of_experience', 'message', 'status', 'rejection_reason', 'reviewed_at'];

    protected function casts(): array
    {
        return ['status' => BranchApplicationStatus::class, 'reviewed_at' => 'datetime'];
    }
}
