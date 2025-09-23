<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationalUnit extends Model
{
    protected $fillable = ['code', 'name'];

    public function jobPositions()
    {
        return $this->hasMany(JobPosition::class, 'organizational_unit_id');
    }
}
