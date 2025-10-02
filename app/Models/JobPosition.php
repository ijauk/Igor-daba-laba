<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPosition extends Model
{
    use HasFactory;
    // Laravel će automatski dodati accessor label u array/JSON output.

    protected $appends = ['label'];
    //protected $table = 'job_positions'; // ako nije standardno ime
    protected $fillable = ['name', 'description', 'min_salary', 'max_salary', 'is_active', 'education_id', 'organizational_unit_id'];
    public function jobPostings()
    {
        return $this->hasMany(JobPosting::class, 'job_position_id');
    }
    public function organizationalUnit()
    {
        return $this->hasOne(OrganizationalUnit::class, 'id', 'organizational_unit_id');
    }
   public function hiringPlanItem()
    {
         return $this->hasMany(HiringPlanItem::class, 'job_position_id');    
    }
    public function getLabelAttribute(): string
    {
        // dohvaćamo organizacijsku jedinicu
        $ou = $this->organizationalUnit;

        // lijevi dio se sastoji od ou code, job_subnumber i incumbent_subnumber

        // collect je helper funkcija koja kreira Laravel kolekciju iz niza
        // omogućava korištenje metode filter kasnije u lancu poziva
        $left = collect(
            [
                $ou?->code,
                $this->job_subnumber,
                $this->incumbent_subnumber
            ]

        )->filter(fn($v) => $v && trim($v) !== '')->implode('.'); // sa filter metodom uklanjam null/empty vrijednosti kao i whitespace-only

        // filter je metoda laravel kolekcija koja uklanja sve elemente za koje callback vraća false
        // $v je parametar koji predstavlja trenutnu vrijednost u kolekcij dok funkcija prolazi kroz nju
        // koristimo arrow function sintaksu (fn) koja je kraća verzija za definiranje anonimne funkcije i vraća true or false za svaki element
        // u ovom slučaju, vraća true ako je vrijednost $v istinita (nije null, false, 0, prazan string ili prazan array) i ako trim($v) nije prazan string
        // implode spaja elemente kolekcije u string, razdvojene točkom


        //desni dio počinje sa nazivom posla
        $right = trim($this->name ?? '');
        if ($ou?->name) { // ako ima ime, dodaj ga ispred naziva posla
            $right = $right . ' | ' . $ou->name;
        }

        return ($left ? $left . ' ' : '') . $right;
    }
}
