<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestScript extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'project_id',
        'file_id',
        'name',
        'description',
        'threads',
        'ramp_up_period',
        'loops',
        'status'
    ];
}
