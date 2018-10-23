<?php

namespace App\Components\Robot;

use App\Components\Robot\Map\Cell;

/**
 * Class Map
 *
 * @package App\Components\Robot
 */
class Map
{
    /**
     * @var Cell[][]
     */
    private $cells;

    /**
     * Map constructor
     *
     * @param Cell[][] $cells
     */
    public function __construct(array $cells)
    {
        $this->cells = $cells;
    }

    /**
     * @param int $x
     * @param int $y
     *
     * @return Cell|null
     */
    public function getCell(int $x, int $y): ?Cell
    {
        return $this->cells[$y][$x] ?? null;
    }
}
