<?php

namespace App\Tests\Feature;

use App\Tests\TestCase;

/**
 * Class RobotTest
 *
 * @package App\Tests\Feature
 */
class RobotTest extends TestCase
{
    /**
     * It shows robot cleans
     *
     * @return void
     */
    public function testClean()
    {
        $this->post('/robot/clean');

        $this->assertEquals(200, $this->response->getStatusCode());

        $this->assertEquals("1", $this->response->getContent());
    }
}
