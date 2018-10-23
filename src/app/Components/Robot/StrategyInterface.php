<?php

namespace App\Components\Robot;

/**
 * Interface BackOffStrategyInterface
 *
 * @package App\Components\Robot
 */
interface StrategyInterface
{
    /**
     * @return Program
     */
    public function getProgram(): Program;

    /**
     * @return StrategyInterface|null
     */
    public function getNext(): ?StrategyInterface;
}
