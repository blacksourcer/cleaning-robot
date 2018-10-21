<?php

namespace App\Components\Robot\Program;

/**
 * Class Instruction
 *
 * @package App\Components\Robot\Program
 */
class Instruction
{
    const TURN_LEFT = "TL";

    const TURN_RIGHT = "TR";

    const ADVANCE = "A";

    const BACK = "B";

    const CLEAN = "C";

    /**
     * @param string $instruction
     * @return bool
     */
    public static function isValid(string $instruction): bool
    {
        return in_array($instruction, [
            self::TURN_LEFT,
            self::TURN_RIGHT,
            self::ADVANCE,
            self::BACK,
            self::CLEAN,
        ]);
    }
}
