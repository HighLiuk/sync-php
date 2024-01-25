<?php

namespace HighLiuk\Sync;

class Utils
{
    /**
     * Convert a variable to a string.
     */
    public static function toString(mixed $var): string
    {
        if (is_string($var)) {
            return $var;
        }

        return json_encode($var) ?: '';
    }
}
