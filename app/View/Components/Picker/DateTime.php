<?php

namespace App\View\Components\Picker;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DateTime extends Component
{
    /**
     * Create a new component instance.
     */
     public string $name;
    public string $id;
    public ?string $value;
    public string $placeholder;
    public string $format;
    public string $displayFormat;
    public bool $sideBySide;
    public int $stepping;
    public ?string $minDate;
    public ?string $maxDate;
    public bool $useSeconds;
    public bool $use24Hours;
    public bool $keepOpen;
    public bool $buttonsToday;
    public bool $buttonsClear;
    public bool $buttonsClose;
    public string $dropdownParent;
    public bool $readonly;
    public bool $disabled;
    public bool $required;
    public string $autocomplete;
    public function __construct(
        string $name,
        ?string $id = null,
        ?string $value = null,
        string $placeholder = 'Odaberi datum i vrijeme',
        string $format = 'yyyy-MM-dd HH:mm',
        ?string $displayFormat = null,
        bool $sideBySide = false,
        int $stepping = 5,
        ?string $minDate = null,
        ?string $maxDate = null,
        bool $useSeconds = false,
        bool $use24Hours = true,
        bool $keepOpen = false,
        bool $buttonsToday = true,
        bool $buttonsClear = true,
        bool $buttonsClose = true,
        string $dropdownParent = 'body',
        bool $readonly = false,
        bool $disabled = false,
        bool $required = false,
        string $autocomplete = 'off'

    )
    {
        $this->name = $name;
        $this->id = $id ?? $name;
        $this->value = $value;
        $this->placeholder = $placeholder;
        $this->format = $format;
        $this->displayFormat = $displayFormat ?? $format;
        $this->sideBySide = $sideBySide;
        $this->stepping = $stepping;
        $this->minDate = $minDate;
        $this->maxDate = $maxDate;
        $this->useSeconds = $useSeconds;
        $this->use24Hours = $use24Hours;
        $this->keepOpen = $keepOpen;
        $this->buttonsToday = $buttonsToday;
        $this->buttonsClear = $buttonsClear;
        $this->buttonsClose = $buttonsClose;
        $this->dropdownParent = $dropdownParent;
        $this->readonly = $readonly;
        $this->disabled = $disabled;
        $this->required = $required;
        $this->autocomplete = $autocomplete;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.picker.date-time');
    }
}
