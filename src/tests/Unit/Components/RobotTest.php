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
     * @covers Robot::charge
     * @covers Robot::getBattery
     *
     * @return void
     *
     * @throws \Throwable
     */
    public function testChargeInvalidVolume()
    {
        $robot = new Robot();

        $this->expectException(Robot\Exception\BatteryException::class);

        $robot->charge(-10);
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
                [Robot\Map\Cell::space(), Robot\Map\Cell::space(),],
                [Robot\Map\Cell::space(), Robot\Map\Cell::column(),],
            ]),
            new Robot\Location(0, 0),
            Robot\Direction::north()
        );

        $this->assertEquals(new Robot\Location(0, 0), $robot->getLocation());
        $this->assertEquals(Robot\Direction::north(), $robot->getDirection());
    }

    /**
     * @covers Robot::place
     *
     * @return void
     *
     * @throws \Throwable
     */
    public function testPlaceInvalidLocation()
    {
        $robot = new Robot();

        $this->expectException(Robot\Exception\LocationException::class);

        $robot->place(
            new Robot\Map([
                [Robot\Map\Cell::space(), Robot\Map\Cell::space(),],
                [Robot\Map\Cell::space(), Robot\Map\Cell::column(),],
            ]),
            new Robot\Location(0, -1),
            Robot\Direction::north()
        );
    }

    /**
     * @covers Robot::place
     *
     * @return void
     *
     * @throws \Throwable
     */
    public function testPlaceInvalidLocationColumn()
    {
        $robot = new Robot();

        $this->expectException(Robot\Exception\LocationException::class);

        $robot->place(
            new Robot\Map([
                [Robot\Map\Cell::space(), Robot\Map\Cell::space(),],
                [Robot\Map\Cell::space(), Robot\Map\Cell::column(),],
            ]),
            new Robot\Location(1, 1),
            Robot\Direction::north()
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

    /**
     * @covers Robot::run
     * @covers Robot::getLocation
     * @covers Robot::getDirection
     * @covers Robot::getVisited
     * @covers Robot::getCleaned
     * @covers Robot::getBattery
     *
     * @return void
     *
     * @throws \Throwable
     */
    public function testRun()
    {
        $robot = new Robot();

        $robot
            ->charge(10)
            ->place(
                new Robot\Map([
                    [Robot\Map\Cell::space(), Robot\Map\Cell::space(),],
                    [Robot\Map\Cell::space(), Robot\Map\Cell::column(),],
                ]),
                new Robot\Location(0, 0),
                Robot\Direction::north()
            )
            ->run(new Robot\Program([
                Robot\Program\Instruction::turnRight(),
            ]));

        $this->assertEquals(new Robot\Location(0, 0), $robot->getLocation());
        $this->assertEquals(Robot\Direction::east(), $robot->getDirection());
        $this->assertEquals([new Robot\Location(0, 0)], $robot->getVisited());
        $this->assertEquals([], $robot->getCleaned());
        $this->assertEquals(9, $robot->getBattery());

        $robot->run(new Robot\Program([
            Robot\Program\Instruction::advance(),
        ]));

        $this->assertEquals(new Robot\Location(1, 0), $robot->getLocation());
        $this->assertEquals(Robot\Direction::east(), $robot->getDirection());
        $this->assertEquals([new Robot\Location(0, 0), new Robot\Location(1, 0)], $robot->getVisited());
        $this->assertEquals([], $robot->getCleaned());
        $this->assertEquals(7, $robot->getBattery());

        $robot->run(new Robot\Program([
            Robot\Program\Instruction::clean(),
        ]));

        $this->assertEquals(new Robot\Location(1, 0), $robot->getLocation());
        $this->assertEquals(Robot\Direction::east(), $robot->getDirection());
        $this->assertEquals([new Robot\Location(0, 0), new Robot\Location(1, 0)], $robot->getVisited());
        $this->assertEquals([ new Robot\Location(1, 0)], $robot->getCleaned());
        $this->assertEquals(2, $robot->getBattery());

        $robot->run(new Robot\Program([
            Robot\Program\Instruction::turnLeft(),
        ]));

        $this->assertEquals(new Robot\Location(1, 0), $robot->getLocation());
        $this->assertEquals(Robot\Direction::north(), $robot->getDirection());
        $this->assertEquals(new Robot\Location(1, 0), $robot->getLocation());
        $this->assertEquals([new Robot\Location(0, 0), new Robot\Location(1, 0)], $robot->getVisited());
        $this->assertEquals([ new Robot\Location(1, 0)], $robot->getCleaned());
        $this->assertEquals(1, $robot->getBattery());
    }

    /**
     * @covers Robot::run
     *
     * @return void
     *
     * @throws \Throwable
     */
    public function testRunInvalidState()
    {
        $robot = new Robot();

        $this->expectException(Robot\Exception\StateException::class);

        $robot->run(new Robot\Program([
            Robot\Program\Instruction::turnRight(),
        ]));
    }
}
