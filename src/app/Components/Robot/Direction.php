<?php

namespace App\Components\Robot;

use App\Types\Enum;

/**
 * Class Direction
 *
 * @method static parse($value):Direction
 *
 * @package App\Components\Robot
 */
class Direction extends Enum
{
    /**
     * @var string[]
     */
    protected static $values = [
        "N",
        "E",
        "W",
        "S",
    ];

    /**
     * @return Direction
     */
    public static function north(): Direction
    {
        return static::parse("N");
    }

    /**
     * @return Direction
     */
    public static function east(): Direction
    {
        return static::parse("E");
    }

    /**
     * @return Direction
     */
    public static function south(): Direction
    {
        return static::parse("S");
    }

    /**
     * @return Direction
     */
    public static function west(): Direction
    {
        return static::parse("W");
    }

    /**
     * @return Direction
     */
    public function getClockwise(): Direction
    {
        switch ($this) {
            case static::north():
                return static::east();

            case static::east():
                return static::south();

            case static::south():
                return static::west();
        }

        return static::north();
    }

    /**
     * @return Direction
     */
    public function getCounterClockwise(): Direction
    {
        switch ($this) {
            case static::north():
                return static::west();

            case static::west():
                return static::south();

            case static::south():
                return static::east();
        }

        return static::north();
    }
}
