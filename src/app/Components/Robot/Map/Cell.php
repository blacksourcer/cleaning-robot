<?php

namespace App\Components\Robot\Map;

/**
 * Class Cell
 *
 * @package App\Components\Robot\Map
 */
class Cell
{
    const SPACE = "S";

    const COLUMN = "C";

    /**
     * @param string $cell
     * @return bool
     */
    public static function isValid(string $cell): bool
    {
        return in_array($cell, [
            self::SPACE,
            self::COLUMN,
        ]);
    }
}
