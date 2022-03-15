<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filename extends Model
{
    use HasFactory;

    protected $fillable = [
        'hash',
        'name',
    ];
}
