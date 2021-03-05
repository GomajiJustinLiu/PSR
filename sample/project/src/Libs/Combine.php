<?php

/**
 * Combine Library
 */

namespace Gomaji\Demo\Libs;

class Combine
{
    public static function concat(string $str1, string $str2): string
    {
        return $str1 . ' ... ' . $str2;
    }
}
