<?php

namespace App\Components\Robot;

/**
 * Class Strategy
 *
 * @package App\Components\Robot
 */
class Strategy implements StrategyInterface
{
    /**
     * @var \App\Components\Robot\StrategyInterface
     */
    private $next;

    /**
     * @var \App\Components\Robot\Program
     */
    private $program;

    /**
     * Strategy constructor
     *
     * @param \App\Components\Robot\Program $program
     * @param \App\Components\Robot\StrategyInterface|null $strategy
     */
    public function __construct(Program $program, StrategyInterface $strategy = null)
    {
        $this->program = $program;
        $this->next = $strategy;
    }

    /**
     * @return Program
     */
    public function getProgram(): Program
    {
        return $this->program;
    }

    /**
     * @return StrategyInterface|null
     */
    public function getNext(): ?StrategyInterface
    {
        return $this->next;
    }
}