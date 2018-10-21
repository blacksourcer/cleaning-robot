<?php

namespace App\Components\Robot;

/**
 * Class Direction
 *
 * @package App\Components\Robot
 */
class Direction
{
    const NORTH = "N";

    const EAST = "E";

    const SOUTH = "S";

    const WEST = "W";

    /**
     * @param string $direction
     * @return bool
     */
    public static function isValid(string $direction): bool
    {
        return in_array($direction, [
            self::NORTH,
            self::EAST,
            self::SOUTH,
            self::WEST,
        ]);
    }
}
