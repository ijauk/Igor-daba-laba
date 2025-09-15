<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CandidatePosting extends Model
{
    protected $fillable = [
        'candidate_id',
        'posting_id',
    ];
    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }
    public function posting()
    {
        return $this->belongsTo(Job_posting::class);
    }

}
