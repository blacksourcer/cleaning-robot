<?php

namespace App\Console\Commands\Robot;

use App\Components\Robot;
use App\Components\Helpers\Robot as RobotHelper;

use App\Exceptions\ParseException;

use Illuminate\Console\Command;

/**
 * Class Run
 *
 * @package App\Console\Commands\Robot
 */
class Run extends Command
{
    /**
     * @var Robot
     */
    private $robot;

    /**
     * @var string
     */
    protected $name = "robot:run";

    /**
     * @var string
     */
    protected $description = "Run the robot";
    /**
     * @var string
     */
    protected $signature = "robot:run {source} {result}";

    /**
     * Run constructor
     *
     * @param Robot $robot
     */
    public function __construct(Robot $robot)
    {
        parent::__construct();

        $this->robot = $robot;
    }

    /**
     * @return Robot
     */
    public function getRobot(): Robot
    {
        return $this->robot;
    }

    /**
     * Run the robot
     *
     * @return void
     */
    public function handle()
    {
        $sourceFile = $this->input->getArgument("source");
        $resultFile = $this->input->getArgument("result");

        if (!\is_file($sourceFile)
            || !($sourceContent = \file_get_contents($sourceFile))
            || !($source = \json_decode($sourceContent, true))
        ) {
            $this->error("Failed to parse input at \"$sourceFile\"");
            return;
        }

        $robot = $this->getRobot();

        try {
            $robot
                ->charge(RobotHelper::parseBattery($source))
                ->place(
                    RobotHelper::parseMap($source),
                    RobotHelper::parseStartLocation($source),
                    RobotHelper::parseStartDirection($source)
                );

            $program = RobotHelper::parseProgram($source);
        } catch (ParseException $ex) {
            $this->error("Failed to parse input at \"$sourceFile\": {$ex->getMessage()}");
            return;
        } catch (Robot\Exceptions\BatteryException | Robot\Exceptions\LocationException $ex) {
            $this->error("Initial data is invalid: {$ex->getMessage()}");
            return;
        }

        try {
            $robot->run($program);
        } catch (Robot\Exceptions\BatteryException $ex) {
            $this->warn("Robot ran out of its battery");
        } catch (Robot\Exceptions\LocationException $ex) {
            $this->warn("Robot has stuck");
        } catch (Robot\Exceptions\Exception $ex) {
            $this->error("Generic error: {$ex->getMessage()}");
            return;
        }

        $result = \json_encode(RobotHelper::dumpRobotStats($robot));

        if (!\file_put_contents($resultFile, $result)) {
            $this->error("Failed to write result to \"$resultFile\"");
            return;
        }

        $this->info("Done");
    }
}