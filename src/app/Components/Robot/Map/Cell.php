<?php

namespace App\Components\Robot\Map;

use App\Types\Enum;

/**
 * Class Cell
 *
 * @method static parse($value):Cell
 *
 * @package App\Components\Robot\Map
 */
class Cell extends Enum
{
    /**
     * @var string[]
     */
    protected static $values = [
        "S",
        "C",
    ];

    /**
     * @return Cell
     */
    public static function space(): Cell
    {
        return static::tryParse("S");
    }

    /**
     * @return Cell
     */
    public static function column(): Cell
    {
        return static::tryParse("C");
    }
}
