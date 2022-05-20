<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'project_id',
        'test_script_id',
        'threads',
        'ramp_up_period',
        'loops',
        'response_time',
        'error_rate',
        'start_at',
        'end_at',
        'file_name'
    ];
}
