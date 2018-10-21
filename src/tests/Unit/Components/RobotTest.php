<?php

namespace App\Tests\Unit\Components;

use App\Components\Robot;

use App\Tests\TestCase;

/**
 * Class RobotTest
 *
 * @package App\Tests\Unit\Components
 */
class RobotTest extends TestCase
{
    /**
     * @covers Robot::charge
     * @covers Robot::getBattery
     *
     * @return void
     *
     * @throws \Throwable
     */
    public function testCharge()
    {
        $robot = new Robot();
        $robot->charge(10);

        $this->assertEquals(10, $robot->getBattery());
    }

    /**
     * @covers Robot::getBattery
     *
     * @return void
     */
    public function testGetBatteryInvalidState()
    {
        $robot = new Robot();

        $this->expectException(Robot\Exception\StateException::class);

        $robot->getBattery();
    }

    /**
     * @covers Robot::place
     * @covers Robot::getLocation
     * @covers Robot::getDirection
     *
     * @return void
     *
     * @throws \Throwable
     */
    public function testPlace()
    {
        $robot = new Robot();

        $robot->place(
            new Robot\Map([
                ['S', 'S',],
                ['S', 'C',],
            ]),
            new Robot\Location(0, 0),
            Robot\Direction::NORTH
        );

        $this->assertEquals(new Robot\Location(0, 0), $robot->getLocation());
        $this->assertEquals(Robot\Direction::NORTH, $robot->getDirection());
    }

    /**
     * @covers Robot::place
     *
     * @return void
     *
     * @throws \Throwable
     */
    public function testPlaceInvalidDirection()
    {
        $robot = new Robot();

        $this->expectException(Robot\Exception\PlacementException::class);

        $robot->place(
            new Robot\Map([
                ['S', 'S',],
                ['S', 'C',],
            ]),
            new Robot\Location(0, 0),
            'invalid'
        );
    }

    /**
     * @covers Robot::getLocation
     *
     * @return void
     *
     * @throws \Throwable
     */
    public function testGetLocationInvalidState()
    {
        $robot = new Robot();

        $this->expectException(Robot\Exception\StateException::class);

        $robot->getLocation();
    }

    /**
     * @covers Robot::getDirection
     *
     * @return void
     *
     * @throws \Throwable
     */
    public function testGetDirectionInvalidState()
    {
        $robot = new Robot();

        $this->expectException(Robot\Exception\StateException::class);

        $robot->getLocation();
    }
}
