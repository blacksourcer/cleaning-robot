<?php

namespace App\Console\Commands\Robot;

use App\Components\Robot;
use Illuminate\Console\Command;

/**
 * Class Run
 *
 * @package App\Console\Commands\Robot
 */
class RunCommand extends Command
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
        $this->info("Robot start: {$this->getRobot()->clean()}");
    }
}