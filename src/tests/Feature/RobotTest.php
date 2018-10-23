<?php

namespace App\Tests\Feature;

use App\Tests\TestCase;

/**
 * Class RobotTest
 *
 * @package App\Tests\Feature
 */
abstract class RobotTest extends TestCase
{
    /**
     * @return string[][]
     */
    public function filesDataProvider()
    {
        return [
            "Test1" => [TESTS_DATA_DIR . "/test1.json", TESTS_DATA_DIR . "/test1_result.json"],
            "Test2" => [TESTS_DATA_DIR . "/test2.json", TESTS_DATA_DIR . "/test2_result.json"],
        ];
    }

    /**
     * @param $expected
     * @param $actual
     * @param string $message
     * @param float $delta
     * @param int $maxDepth
     * @param bool $ignoreCase
     */
    public function assertEqualsCanonicalize(
        $expected,
        $actual,
        string $message = '',
        float $delta = 0.0,
        int $maxDepth = 10,
        bool $ignoreCase = false
    ) {
        $this->assertEquals($expected, $actual, $message, $delta, $maxDepth, true, $ignoreCase);
    }
}
