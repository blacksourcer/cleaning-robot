<?php

namespace App\Components\Robot;

use App\Components\Robot\Map\Cell;

use App\Components\Robot\Map\Exception as MapException;

/**
 * Class Map
 *
 * @package App\Components\Robot
 */
class Map
{
    /**
     * @var string[][]
     */
    private $data;

    /**
     * Map constructor
     *
     * @param string[][] $data
     *
     * @throws MapException
     */
    public function __construct(array $data)
    {
        foreach ($data as $row) {
            foreach ($row as $cell) {
                if ((null !== $cell) && !Cell::isValid($cell)) {
                    throw new MapException("Invalid cell value \"$cell\"");
                }
            }
        }

        $this->data = $data;
    }

    /**
     * @param int $row
     * @param int $column
     *
     * @return null|string
     */
    public function getCell(int $row, int $column): ?string
    {
        return $this->data[$row][$column] ?? null;
    }
}
