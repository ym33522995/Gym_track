<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function records()
    {
        return $this->belongsToMany(
            Record::class, 
            'record_exercise', 
            'exercise_id', 
            'record_id',
        )->withPivot(['weight', 'rep', 'notes'])->withTimestamps();
    }

    public function templates()
    {
        return $this->belongsToMany(
            Template::class, 
            'template_content', 
            'exercise_id', 
            'template_id',
        )->withPivot(['order', 'weight', 'rep', 'set'])->withTimestamps();
    }
}
