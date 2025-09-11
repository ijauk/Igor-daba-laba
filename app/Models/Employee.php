<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Support\Facades\Auth;

class Employee extends Model
{
    protected $fillable = ['user_id', 'email', 'phone', 'first_name', 'last_name', 'position'];

    //veza na usera
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function jobPostings()
    {
        return $this->hasMany(Job_posting::class);
    }
}
