<?php

namespace App\Tests\Feature;

use App\Tests\TestCase;

/**
 * Class RobotTest
 *
 * @package App\Tests\Feature
 */
class IndexTest extends TestCase
{
    /**
     * It shows that application is working.
     *
     * @return void
     */
    public function testApp()
    {
        $this->get('/');

        $this->assertEquals(200, $this->response->getStatusCode());
        $this->assertEquals($this->app->version(), $this->response->getContent());
    }
}
