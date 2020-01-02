<?php

namespace Codbear\Alaska\Services;

abstract class Security
{
    public static function protectString(string $string): string {
        return htmlspecialchars($string, ENT_QUOTES);
    }
}
