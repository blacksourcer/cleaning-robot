<?php

namespace App\Components\Helpers;

use App\Components\Robot\Direction;
use App\Components\Robot\Location;
use App\Components\Robot\Map;

use App\Components\Robot\Program;
use App\Components\RobotInterface;
use App\Exceptions\ParseException;

/**
 * Class Robot
 *
 * @package App\Components\Helpers
 */
class Robot
{
    /**
     * @param array $rawData
     *
     * @return Map
     *
     * @throws ParseException
     */
    public static function parseMap(array $rawData): Map
    {
        if (!isset($rawData["map"]) || !\is_array($rawData["map"])) {
            throw new ParseException("Map section is not found or invalid");
        }

        return new Map(array_map(function ($row) {
            if (!\is_array($row)) {
                throw new ParseException("Map section is invalid");
            }

            return array_map(function ($cell) {
                return $cell !== "null"
                    ? Map\Cell::parse($cell)
                    : null;
            }, $row);
        }, $rawData["map"]));
    }

    /**
     * @param array $rawData
     *
     * @return Location
     *
     * @throws ParseException
     */
    public static function parseStartLocation(array $rawData): Location
    {
        if (!isset($rawData["start"])) {
            throw new ParseException("Start section is not found");
        }

        if (!isset($rawData["start"]["X"]) || !\is_int($x = $rawData["start"]["X"])) {
            throw new ParseException("Start section's X coordinate is invalid");
        }

        if (!isset($rawData["start"]["Y"]) || !\is_int($y = $rawData["start"]["Y"])) {
            throw new ParseException("Start section's Y coordinate is invalid");
        }

        return new Location($x, $y);
    }

    /**
     * @param array $rawData
     *
     * @return Direction
     *
     * @throws ParseException
     */
    public static function parseStartDirection(array $rawData): Direction
    {
        if (!isset($rawData["start"]["facing"])) {
            throw new ParseException("Start section is not found or missing 'facing' param");
        }

        return Direction::parse($rawData["start"]["facing"]);
    }

    /**
     * @param array $rawData
     *
     * @return Program
     *
     * @throws ParseException
     */
    public static function parseProgram(array $rawData): Program
    {
        if (!isset($rawData["commands"]) || !\is_array($rawData["commands"])) {
            throw new ParseException("Commands section is not found or invalid");
        }

        return new Program(array_map(function (string $instruction) {
            return Program\Instruction::parse($instruction);
        }, $rawData["commands"]));
    }

    /**
     * @param array $rawData
     *
     * @return int
     *
     * @throws ParseException
     */
    public static function parseBattery(array $rawData): int
    {
        if (!isset($rawData["battery"]) || !\is_int($battery = $rawData["battery"])) {
            throw new ParseException("Battery section is invalid");
        }

        return $battery;
    }

    /**
     * @param RobotInterface $robot
     *
     * @return array
     */
    public static function dumpRobotStats(RobotInterface $robot): array
    {
        $locationMapper = function (Location $location): array {
            return ["X" => $location->getX(), "Y" => $location->getY()];
        };

        return [
            "visited" => array_map($locationMapper, $robot->getVisited()),
            "cleaned" => array_map($locationMapper, $robot->getCleaned()),
            "final" => array_merge($locationMapper($robot->getLocation()), [
                "facing" => (string)$robot->getDirection(),
            ]),
            "battery" => $robot->getBattery(),
        ];
    }
}