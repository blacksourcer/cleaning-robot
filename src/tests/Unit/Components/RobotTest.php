<?php

namespace App\Tests\Unit\Components;

use App\Components\Robot;

use App\Tests\TestCase;

class RobotTest extends TestCase
{
    /**
     * @covers Robot::clean
     * @return void
     */
    public function testCleaning()
    {
        $robot = new Robot();

        $this->assertTrue($robot->clean());
    }
}
