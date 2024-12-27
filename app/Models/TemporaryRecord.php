<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemporaryRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'exercise_id',
        'weight',
        'rep',
        'set',
        'notes',
    ];

}
