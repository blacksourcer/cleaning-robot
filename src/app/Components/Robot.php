<?php

namespace App\Components;

use App\Components\Robot\Direction;
use App\Components\Robot\Location;
use App\Components\Robot\Map;
use App\Components\Robot\Program;
use App\Components\Robot\Result;

use App\Components\Robot\Exception;
use App\Components\Robot\Exception\StateException;
use App\Components\Robot\Exception\PlacementException;

/**
 * Class Robot
 *
 * @package App\Components
 */
class Robot implements RobotInterface
{
    /**
     * @var int
     */
    private $battery;

    /**
     * @var Map
     */
    private $map;

    /**
     * @var Location
     */
    private $location;

    /**
     * @var string
     */
    private $direction;

    /**
     * @param Map $map
     *
     * @return Robot
     */
    protected function setMap(Map $map): self
    {
        $this->map = $map;

        return $this;
    }

    /**
     * @param Location $location
     *
     * @return Robot
     */
    protected function setLocation(Location $location): self
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @param string $direction
     *
     * @return Robot
     *
     * @throws PlacementException
     */
    protected function setDirection(string $direction): self
    {
        if (!Direction::isValid($direction)) {
            throw new PlacementException(
                "Direction must be of (" . Direction::NORTH . ", " . Direction::EAST . ", " . Direction::SOUTH . ", " . Direction::SOUTH . ")"
            );
        }

        $this->direction = $direction;

        return $this;
    }

    /**
     * Robot constructor
     */
    public function __construct()
    {
    }

    /**
     * @return int
     */
    public function getBattery(): int
    {
        if (null === $this->battery) {
            throw new StateException("The robot has not been charged yet");
        }

        return $this->battery;
    }

    /**
     * @return Location
     */
    public function getLocation(): Location
    {
        if (null === $this->location) {
            throw new StateException("The robot has not been placed yet");
        }

        return $this->location;
    }

    /**
     * @return string
     */
    public function getDirection(): string
    {
        if (null === $this->direction) {
            throw new StateException("The robot has not been placed yet");
        }

        return $this->direction;
    }

    /**
     * @param int $battery
     *
     * @return RobotInterface
     *
     * @throws Exception
     */
    public function charge(int $battery): RobotInterface
    {
        if ($battery < 0) {
            throw new Exception("Battery charge should be >= 0");
        }

        $this->battery = $battery;

        return $this;
    }

    /**
     * @param Map $map
     * @param Location $location
     * @param string $direction
     *
     * @return RobotInterface
     *
     * @throws PlacementException
     */
    public function place(Map $map, Location $location, string $direction): RobotInterface
    {
        return $this
            ->setMap($map)
            ->setLocation($location)
            ->setDirection($direction);
    }

    /**
     * @param Program $program
     *
     * @return Result
     */
    public function start(Program $program): Result
    {
        return new Result();
    }
}