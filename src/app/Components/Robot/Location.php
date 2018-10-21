<?php

namespace App\Components\Robot;

use App\Components\Robot\Location\Exception as LocationException;

/**
 * Class Location
 *
 * @package App\Components\Robot
 */
class Location
{
    /**
     * @var int
     */
    private $x;

    /**
     * @var int
     */
    private $y;

    /**
     * Location constructor
     *
     * @param int $x
     * @param int $y
     *
     * @throws LocationException
     */
    public function __construct(int $x, int $y)
    {
        $this->setX($x);
        $this->setY($y);
    }

    /**
     * @return int
     */
    public function getX(): int
    {
        return $this->x;
    }

    /**
     * @param int $x
     *
     * @return Location
     *
     * @throws LocationException
     */
    public function setX(int $x): self
    {
        if ($x < 0) {
            throw new LocationException("X must be >= 0");
        }

        $this->x = $x;

        return $this;
    }

    /**
     * @return int
     */
    public function getY(): int
    {
        return $this->y;
    }

    /**
     * @param int $y
     *
     * @return Location
     *
     * @throws LocationException
     */
    public function setY(int $y): self
    {
        if ($y < 0) {
            throw new LocationException("Y must be >= 0");
        }

        $this->y = $y;

        return $this;
    }
}
