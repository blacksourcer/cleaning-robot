<?php

namespace App\Components\Robot;

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
     */
    public function setX(int $x): Location
    {

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
     */
    public function setY(int $y): Location
    {
        $this->y = $y;

        return $this;
    }

    /**
     * @return Location
     */
    public function up(): Location
    {
        return new Location($this->getX(), $this->getY() - 1);
    }

    /**
     * @return Location
     */
    public function right(): Location
    {
        return new Location($this->getX() + 1, $this->getY());
    }

    /**
     * @return Location
     */
    public function down(): Location
    {
        return new Location($this->getX(), $this->getY() + 1);
    }

    /**
     * @return Location
     */
    public function left(): Location
    {
        return new Location($this->getX() - 1, $this->getY());
    }
}
