<?php

namespace App\View\Components\Select;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TomSelect extends Component
{
    public function __construct(
        public string $name,
        public ?string $id = null,
        public ?string $placeholder = 'Traži…',
        public bool $multiple = false,
        public ?string $endpoint = null,       // npr. route('api.job-positions')
        public ?string $valueField = 'id',
        public ?string $labelField = 'text',
        public ?string $searchField = 'text',
        public ?int $minInputLength = 0,
        public ?int $maxOptions = 50,
        public ?string $dropdownParent = 'body', // selector ili 'body'
        public mixed $selected = null,          // value ili [values]
        public array $options = []              // [value => label] za statički
    ) {
    }

    public function render(): View|Closure|string
    {
        return view('components.select.tom-select');
    }
}