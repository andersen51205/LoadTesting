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
        'is_incremental',
        'start_thread',
        'end_thread',
        'increment_amount',
        'threads',
        'ramp_up_period',
        'loops',
        'status'
    ];

    public function filename()
    {
        return $this->belongsTo('App\Models\Filename', 'file_id', 'id');
    }
}
