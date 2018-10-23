<?php

namespace App\Http\Controllers;

use App\Components\Robot;
use App\Components\Helpers\Robot as RobotHelper;

use App\Exceptions\ParseException;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
     * @param string $content
     *
     * @return Response
     */
    protected function badRequest(string $content = "Bad request"): Response
    {
        return response()->make($content, 400);
    }

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
     * @param Request $request
     * @return string
     */
    public function run(Request $request)
    {
        if (("application/json" !== $request->headers->get("Content-Type"))
            || !($content = $request->getContent())
            || !($data = \json_decode($content, true))
        ) {
            return $this->badRequest();
        }

        $robot = $this->getRobot();

        try {
            $robot
                ->charge(RobotHelper::parseBattery($data))
                ->place(
                    RobotHelper::parseMap($data),
                    RobotHelper::parseStartLocation($data),
                    RobotHelper::parseStartDirection($data)
                );

            $program = RobotHelper::parseProgram($data);
        } catch (ParseException $ex) {
            return $this->badRequest("Failed to parse the request: {$ex->getMessage()}");
        } catch (Robot\Exceptions\BatteryException | Robot\Exceptions\LocationException $ex) {
            return $this->badRequest("Initial data is invalid: {$ex->getMessage()}");
        }

        try {
            $robot->run($program);
        } catch (Robot\Exceptions\BatteryException | Robot\Exceptions\LocationException $ex) {
            /** No specific response */
        } catch (Robot\Exceptions\Exception $ex) {
            return response()->make("Generic error: {$ex->getMessage()}", 500);
        }

        return response()->json(RobotHelper::dumpRobotStats($robot));
    }

    #endregion
}
