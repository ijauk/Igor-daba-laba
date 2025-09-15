<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'resume',
        'oib',
        'address',
        'city',
        'postal_code'
    ];
    public function postings()
    {
        return $this->belongsToMany(CandidatePosting::class, 'candidate_postings');
    }

}
