<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecordExercise extends Model
{
    use HasFactory;

    protected $table = 'record_exercises';

    public function record()
    {
        return $this->belongsTo(Record::class, 'record_id', 'id');
    }
}
