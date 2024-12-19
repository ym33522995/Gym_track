<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateContent extends Model
{
    use HasFactory;

    protected $fillable = 
    [
        'template_id', 
        'exercise_id',
        'weight', 
        'rep', 
        'set', 
        'order',
    ];

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function exercise()
    {
        return $this->belongsTo(Exercise::class);
    }
}
