<?php

namespace App\Components;

use App\Components\Robot\Direction;
use App\Components\Robot\Location;
use App\Components\Robot\Map;
use App\Components\Robot\Program;

use App\Components\Robot\Exception\StateException;
use App\Components\Robot\Exception\LocationException;
use App\Components\Robot\Exception\BatteryException;
use App\Components\Robot\RuntimeException;

/**
 * Class Robot
 *
 * @package App\Components
 */
class Robot implements RobotInterface
{
    const BATTERY_DRAIN_TURN = 1;

    const BATTERY_DRAIN_ADVANCE = 2;

    const BATTERY_DRAIN_BACK = 3;

    const BATTERY_DRAIN_CLEAN = 5;

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
     * @var Direction
     */
    private $direction;

    /**
     * @var Location[]
     */
    private $visited = [];

    /**
     * @var Location[]
     */
    private $cleaned = [];

    /**
     * @param int $battery
     *
     * @return Robot
     *
     * @throws BatteryException
     */
    protected function setBattery(int $battery): self
    {
        if ($battery < 0) {
            throw new BatteryException("Battery charge should be >= 0");
        }

        $this->battery = $battery;

        return $this;
    }

    /**
     * @param int $volume
     *
     * @return Robot
     *
     * @throws BatteryException
     */
    protected function drainBattery(int $volume): self
    {
        return $this->setBattery($this->getBattery() - $volume);
    }

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
     *
     * @throws LocationException
     */
    protected function setLocation(Location $location): self
    {
        $x = $location->getX();
        $y = $location->getY();

        if (Map\Cell::space() !== $this->getMap()->getCell($x, $y)) {
            throw new LocationException("The robot cannot occupy cell ($x, $y)");
        }

        $this->location = $location;

        return $this;
    }

    /**
     * @param Direction $direction
     *
     * @return Robot
     */
    protected function setDirection(Direction $direction): self
    {
        $this->direction = $direction;

        return $this;
    }

    /**
     * @param Location $location
     *
     * @return Robot
     */
    protected function addVisited(Location $location): self
    {
        $this->visited[] = $location;

        return $this;
    }

    /**
     * @param Location $location
     *
     * @return Robot
     */
    protected function addCleaned(Location $location): self
    {
        $this->cleaned[] = $location;

        return $this;
    }

    /**
     * @return RobotInterface
     *
     * @throws BatteryException
     */
    protected function turnLeft(): RobotInterface
    {
        return $this
            ->setDirection($this->getDirection()->getCounterClockwise())
            ->drainBattery(self::BATTERY_DRAIN_TURN);
    }

    /**
     * @return RobotInterface
     *
     * @throws BatteryException
     */
    protected function turnRight(): RobotInterface
    {
        return $this
            ->setDirection($this->getDirection()->getClockwise())
            ->drainBattery(self::BATTERY_DRAIN_TURN);
    }

    /**
     * @return RobotInterface
     *
     * @throws BatteryException
     * @throws LocationException
     */
    protected function advance(): RobotInterface
    {
        switch ($this->getDirection()) {
            case Direction::north():
                $this->setLocation($this->getLocation()->up());
                break;

            case Direction::east():
                $this->setLocation($this->getLocation()->right());
                break;

            case Direction::south():
                $this->setLocation($this->getLocation()->down());
                break;

            case Direction::west():
                $this->setLocation($this->getLocation()->left());
                break;
        }

        return $this
            ->addVisited($this->getLocation())
            ->drainBattery(self::BATTERY_DRAIN_ADVANCE);
    }

    /**
     * @return RobotInterface
     *
     * @throws BatteryException
     */
    protected function clean(): RobotInterface
    {
        return $this
            ->addCleaned($this->getLocation())
            ->drainBattery(self::BATTERY_DRAIN_CLEAN);
    }

    /**
     * @param Program\Instruction $instruction
     *
     * @return Robot
     *
     * @throws BatteryException
     * @throws LocationException
     */
    protected function execute(Program\Instruction $instruction): RobotInterface
    {
        switch ($instruction)
        {
            case Program\Instruction::turnLeft():
                return $this->turnLeft();

            case Program\Instruction::turnRight():
                return $this->turnRight();

            case Program\Instruction::advance():
                return $this->advance();

            case Program\Instruction::clean():
                return $this->clean();
        }

        throw new RuntimeException("Unsupported instruction \"$instruction\"");
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
     * @return Map
     */
    public function getMap(): Map
    {
        if (null === $this->map) {
            throw new StateException("The map has not been set");
        }

        return $this->map;
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
     * @return Direction
     */
    public function getDirection(): Direction
    {
        if (null === $this->direction) {
            throw new StateException("The robot has not been placed yet");
        }

        return $this->direction;
    }

    /**
     * @return Location[]
     */
    public function getVisited(): array
    {
        return $this->visited;
    }

    /**
     * @return Location[]
     */
    public function getCleaned(): array
    {
        return $this->cleaned;
    }

    /**
     * @param int $battery
     *
     * @return RobotInterface
     *
     * @throws BatteryException
     */
    public function charge(int $battery): RobotInterface
    {
        return $this->setBattery($battery);
    }

    /**
     * @param Map $map
     * @param Location $location
     * @param Direction $direction
     *
     * @return RobotInterface
     *
     * @throws LocationException
     */
    public function place(Map $map, Location $location, Direction $direction): RobotInterface
    {
        return $this
            ->setMap($map)
            ->setLocation($location)
            ->setDirection($direction)
            ->addVisited($this->getLocation());
    }

    /**
     * @param Program|string[] $program
     *
     * @throws BatteryException
     * @throws LocationException
     */
    public function run(Program $program)
    {
        foreach ($program as $instruction) {
            $this->execute($instruction);
        }
    }
}