<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'project_id',
        'question_text',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function choices()
    {
        return $this->hasMany(Choice::class);
    }
}
