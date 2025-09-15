<?php
namespace App\Support;
final class Oib
{
    public static function isValid(string $oib): bool
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
    public static function generate(): string
    {
        $oib = '';
        for ($i = 0; $i < 10; $i++) {
            $oib .= rand(0, 9);
        }

        $a = 10;
        for ($i = 0; $i < 10; $i++) {
            $a = ($a + (int) $oib[$i]) % 10;
            if ($a === 0) {
                $a = 10;
            }
            $a = ($a * 2) % 11;
        }

        $checkDigit = (11 - $a) % 10;

        return $oib . $checkDigit;
    }
    public static function generateUnique(callable $exists, int $maxTries = 1000): string
    {
        static $used = []; // spremi već generirane OIB-ove u ovom pozivu
        for ($i = 0; $i < $maxTries; $i++) {
            $oib = self::generate(); // generiraj novi OIB
            if (isset($used[$oib])) {
                continue; // već generiran u ovom pozivu, pokušaj ponovno
            }

            if ($exists && $exists($oib)) {
                continue; // već postoji u bazi, pokušaj ponovno
            }
            $used[$oib] = true;
            return $oib; // jedinstven OIB, vrati ga
        }
        throw new \RuntimeException('Nije moguće generirati jedinstveni OIB unutar zadanog broja pokušaja.');


    }
}