<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function exercises()
    {
        return $this->belongsToMany(
            Exercise::class, // the model related to
            'template_content', // the name of the pivot table
            'template_id', // foreign key
            'exercise_id', // foreign key
        )->withPivot(['order', 'weight', 'rep', 'set'])->withTimestamps();
    }

}
