<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    protected $table = 'educations';
    protected $fillable = ['title', 'abbreviation', 'level', 'remark', 'created_at', 'updated_at'];
    public function getLabelAttribute(): string
    {
        return $this->abbreviation ? "{$this->title} ({$this->abbreviation})" : $this->title;
    }
}