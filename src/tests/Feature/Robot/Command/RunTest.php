<?php

namespace App\Tests\Feature\Robot\Command;

use App\Tests\Feature\RobotTest;

/**
 * Class RunTest
 *
 * @package App\Tests\Feature\Robot\Command
 */
class RunTest extends RobotTest
{

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
        if (!\copy($sourceFile, $sourceTempFile = TESTS_TMP_DIR . "/source.json")) {
            throw new \ErrorException("Failed to copy source file \"$sourceFile\" to \"$sourceTempFile\"");
        }

        $resultTempFile = TESTS_TMP_DIR . "/result.json";

        \exec(ROOT_DIR . "/artisan robot:run \"$sourceTempFile\" \"$resultTempFile\"", $output, $exitCode);

        $this->assertEquals(0, $exitCode, "Invalid exit code $exitCode, command output was:\n" . implode("\n", $output));
        $this->assertEquals(
            \json_decode(\file_get_contents($resultFile), true),
            \json_decode(\file_get_contents($resultTempFile), true)
        );
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
