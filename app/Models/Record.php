<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'user_id',
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function exercises()
    {
        return $this->belongsToMany(
            Exercise::class, // the model related to
            'record_exercise', // the name of the pivot table
            'record_id', // foreign key
            'exercise_id', // foreign key
        )->withPivot(['weight', 'rep', 'notes'])->withTimestamps();
    }

    public function recordExercises()
    {
        return $this->hasMany(RecordExercise::class, 'record_id', 'id');
    }
}
