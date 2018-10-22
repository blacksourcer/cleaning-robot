<?php

namespace App\Components;

use App\Components\Robot\Map;
use App\Components\Robot\Location;
use App\Components\Robot\Direction;
use App\Components\Robot\Program;

use App\Components\Robot\Exception\BatteryException;
use App\Components\Robot\Exception\LocationException;

/**
 * Interface RobotInterface
 *
 * @package App\Components
 */
interface RobotInterface
{
    /**
     * @return int
     */
    public function getBattery(): int;

    /**
     * @return Location
     */
    public function getLocation(): Location;

    /**
     * @return Direction
     */
    public function getDirection(): Direction;

    /**
     * @return Location[]
     */
    public function getVisited(): array;

    /**
     * @return Location[]
     */
    public function getCleaned(): array;

    /**
     * @param int $battery
     *
     * @return RobotInterface
     *
     * @throws BatteryException
     */
    public function charge(int $battery): RobotInterface;

    /**
     * @param Map $map
     * @param Location $location
     * @param Direction $direction
     *
     * @return RobotInterface
     *
     * @throws LocationException
     */
    public function place(Map $map, Location $location, Direction $direction): RobotInterface;

    /**
     * @param Program $program
     *
     * @return void
     */
    public function run(Program $program);
}