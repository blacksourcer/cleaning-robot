<?php

namespace App\Tests\Feature\Command\Robot;

use App\Tests\TestCase;

/**
 * Class RobotTest
 *
 * @package App\Tests\Feature\Command\Robot
 */
class RunTest extends TestCase
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
     * @dataProvider filesDataProvider
     *
     * @param string $sourceFile
     * @param string $resultFile
     *
     * @return void
     *
     * @throws \ErrorException
     */
    public function testRun(string $sourceFile, string $resultFile)
    {
        if (!\copy($sourceFile, $sourceTempFile = TESTS_TMP_DIR . "/source.json")) {
            throw new \ErrorException("Failed to copy source file \"$sourceFile\" to \"$sourceTempFile\"");
        }

        if (!$expectedResult = \json_decode(\file_get_contents($resultFile), true)) {
            throw new \ErrorException("Failed to read expected result from \"$resultFile\"");
        }

        $resultTempFile = TESTS_TMP_DIR . "/result.json";

        \exec(ROOT_DIR . "/artisan robot:run \"$sourceTempFile\" \"$resultTempFile\"", $output, $exitCode);

        $actualResult = \json_decode(\file_get_contents($resultTempFile), true);

        $this->assertEquals(0, $exitCode, "Invalid exit code $exitCode, command output was:\n" . implode("\n", $output));
        $this->assertTrue(\is_file($resultTempFile));
        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @throws \Throwable
     */
    public function tearDown()
    {
        foreach (\glob(TESTS_TMP_DIR . "/*") as $file) {
            if (\is_file($file) && !\unlink($file)) {
                throw new \ErrorException("Failed to delete temp file \"$file\"");
            }
        }
    }
}
