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
        return $this->hasMany(JobPosting::class);
    }

    // accessor za labelu u select komponenti
    public function getLabelAttribute(): string
    {
        $first = trim($this->first_name ?? '');
        $last = trim($this->last_name ?? '');
        $email = trim($this->email ?? '');
        if ($first === '' && $last === '') {
            return $email;
        }
        return ($this->first_name ?? '') . ' ' . ($this->last_name ?? '') . ($this->email ? ' (' . $this->email . ')' : '');
    }
}
