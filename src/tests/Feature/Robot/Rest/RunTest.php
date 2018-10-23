<?php

namespace App\Tests\Feature\Robot\Rest;

use App\Tests\Feature\RobotTest;

/**
 * Class RunTest
 *
 * @package App\Tests\Feature\Robot\Rest
 */
class RunTest extends RobotTest
{
    /**
     * @param $uri
     * @param string|null $json
     *
     * @return RunTest
     */
    public function postJson($uri, string $json = null)
    {
        $this->call(
            "POST",
            $uri,
            [],
            [],
            [],
            [
                'HTTP_CONTENT_LENGTH' => mb_strlen($json, '8bit'),
                'CONTENT_TYPE' => 'application/json',
                'HTTP_ACCEPT' => 'application/json'
            ],
            $json
        );

        return $this;
    }

    /**
     * @dataProvider filesDataProvider
     *
     * @param string $sourceFile
     * @param string $resultFile
     *
     * @return void
     *
     * @throws \Throwable
     */
    public function testRun(string $sourceFile, string $resultFile)
    {
        $this->postJson('/robot/run', \file_get_contents($sourceFile));

        $this->assertEquals(200, $this->response->getStatusCode());
        $this->assertEquals("application/json", $this->response->headers->get("Content-Type"));
        $this->assertEqualsCanonicalize(
            \json_decode(\file_get_contents($resultFile), true),
            \json_decode($this->response->getContent(), true)
        );
    }
}
