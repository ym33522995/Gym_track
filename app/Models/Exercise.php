<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function records()
    {
        return $this->belongsToMany(
            Record::class, 
            TemplateContent::class,
            'record_exercise', 
            'exercise_id', 
            'record_id',
        )->withPivot(['weight', 'rep', 'notes'])->withTimestamps();
    }

    public function templateContents()
    {
        return $this->hasMany(TemplateContent::class);
    }
}
