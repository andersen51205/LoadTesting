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

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function project()
    {
        return $this->belongsTo('App\Models\Project', 'project_id', 'id');
    }

    public function filename()
    {
        return $this->belongsTo('App\Models\Filename', 'file_id', 'id');
    }
}
