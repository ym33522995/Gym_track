<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function templateContents()
    {
        return $this->hasMany(TemplateContent::class);
    }

    public function getAllTemplates()
    {
        return $this->orderBy('updated_at', 'DESC')->get();
    }

}
