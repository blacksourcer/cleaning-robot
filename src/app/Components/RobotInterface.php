<?php

namespace App\Components;

use App\Components\Robot\Map;
use App\Components\Robot\Location;
use App\Components\Robot\Program;
use App\Components\Robot\Result;

use App\Components\Robot\Exception;

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
     * @return string
     */
    public function getDirection(): string;

    /**
     * @param int $battery
     *
     * @return RobotInterface
     *
     * @throws Exception
     */
    public function charge(int $battery): RobotInterface;

    /**
     * @param Map $map
     * @param Location $location
     * @param string $direction
     *
     * @return RobotInterface
     */
    public function place(Map $map, Location $location, string $direction): RobotInterface;

    /**
     * @param Program $program
     *
     * @return Result
     */
    public function start(Program $program): Result;
}