<?php namespace Rabble\Support;

class Str
{

    /**
     * Ensure the length of a string
     *
     * @param string $string
     * @param int    $length
     *
     * @return string
     */
    public static function ensure_length($string, $length)
    {
        return substr(str_pad($string, $length), 0, $length);
    }

    /**
     * Return a "newline character"
     * "\r" and "\n" are really escape sequences that are recognized and replaced by 0x0D and 0x0A respectively
     *
     * @return string
     */
    public static function newline()
    {
        return chr(0x0D).chr(0x0A);
    }

}
