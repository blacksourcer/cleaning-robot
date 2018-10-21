<?php

namespace App\Components\Robot;

/**
 * Class Result
 *
 * @package App\Components\Robot
 */
class Result
{
    /**
     * @var Location[]
     */
    private $visited = [];

    /**
     * @var Location[]
     */
    private $cleaned = [];

    /**
     * @return Location[]
     */
    public function getVisited(): array
    {
        return $this->visited;
    }

    /**
     * @param Location $location
     *
     * @return Result
     */
    public function addVisited(Location $location): self
    {
        $this->visited[] = $location;

        return $this;
    }

    /**
     * @return Location[]
     */
    public function getCleaned(): array
    {
        return $this->cleaned;
    }

    /**
     * @param Location $location
     *
     * @return Result
     */
    public function addCleaned(Location $location): self
    {
        $this->cleaned[] = $location;

        return $this;
    }
}
