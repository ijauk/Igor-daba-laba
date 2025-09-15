<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class JobPositionSelect extends Component
{
    use WithPagination;
    // string koji se automatski puni dok korisnik tipka
    public string $search = '';

    // ID trenutno odabranog zapisa
    public ?int $selectedId = null;

    // Ime odabranog zapisa koji se prikazuje u input polju nakon odabira
    public string $selectedLablel = '';

    // služi za prikazivanje/zatvaranje dropdown liste
    public bool $open = false;

    // broj zapisa po stranici
    public int $perPage = 5;

    // omogućava da se parametar "search" vidi u URL-u i da radi kod refresh stranice
    public $queryString = [
        'search'
    ];

    public function render()
    {

        return view('livewire.job-position-select');
    }
}
