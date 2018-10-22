<?php

namespace App\Components\Robot\Program;

use App\Types\Enum;

/**
 * Class Instruction
 *
 * @method static parse($value):Instruction
 *
 * @package App\Components\Robot\Program
 */
class Instruction extends Enum
{
    /**
     * @var string[]
     */
    protected static $values = [
        "TL",
        "TR",
        "A",
        "B",
        "C",
    ];

    /**
     * @return Instruction
     */
    public static function turnLeft(): Instruction
    {
        return static::parse("TL");
    }

    /**
     * @return Instruction
     */
    public static function turnRight(): Instruction
    {
        return static::parse("TR");
    }

    /**
     * @return Instruction
     */
    public static function advance(): Instruction
    {
        return static::parse("A");
    }

    /**
     * @return Instruction
     */
    public static function back(): Instruction
    {
        return static::parse("B");
    }

    /**
     * @return Instruction
     */
    public static function clean(): Instruction
    {
        return static::parse("C");
    }
}
