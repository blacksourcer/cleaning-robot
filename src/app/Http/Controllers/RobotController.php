<?php

namespace App\Http\Controllers;

use App\Components\Robot;

/**
 * Class RobotController
 *
 * @package App\Http\Controllers
 */
class RobotController extends Controller
{
    /**
     * @var Robot
     */
    private $robot;

    /**
     * RobotController constructor
     *
     * @param Robot $robot
     */
    public function __construct(Robot $robot)
    {
        $this->robot = $robot;
    }

    /**
     * @return Robot
     */
    public function getRobot(): Robot
    {
        return $this->robot;
    }

    #region Action Handlers

    /**
     * @return string
     */
    public function clean()
    {
        return (int)$this->getRobot()->clean();
    }

    #endregion
}
