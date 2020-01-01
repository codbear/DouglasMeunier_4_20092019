<?php

namespace Codbear\Alaska\Services;

trait Security
{
    public static function protectString(string $string): string {
        return htmlspecialchars($string, ENT_QUOTES);
    }
}
