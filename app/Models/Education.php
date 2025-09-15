<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    protected $fillable = ['title', 'abbreviation', 'level', 'remark', 'created_at', 'updated_at'];
}