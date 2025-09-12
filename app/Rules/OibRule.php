<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class OibRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$this->isValidOib($value)) {
            $fail(':attribute nije valjan OIB.');
        }
    }
    public function isValidOib(string $oib)
    {
        // uzimam prvih 10 znamenki
        // A = 10
        // za svaku znamenku od 1 do 10 radim:
        // A = (A + znamenka) mod 10
        // ako je A 0, postavi A na 10
        // A = (A * 2) mod 11
        // kontrolna znamenka = (11 - A) mod 10 
        // Provjera je li OIB točno 11 znamenki
        if (!preg_match('/^\d{11}$/', $oib)) {
            return false;
        }

        $digits = str_split($oib);
        $a = 10;

        for ($i = 0; $i < 10; $i++) {
            $a = ($a + (int) $digits[$i]) % 10;
            if ($a === 0) {
                $a = 10;
            }
            $a = ($a * 2) % 11;
        }

        $checkDigit = (11 - $a) % 10;

        return $checkDigit === (int) $digits[10];
    }
}
