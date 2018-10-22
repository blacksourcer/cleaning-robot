<?php

namespace App\Components\Robot;

use App\Components\Robot\Program\Instruction;

/**
 * Class Program
 *
 * @package App\Components\Robot
 */
class Program implements \Iterator
{
    /**
     * @var string[]
     */
    private $instructions;

    /**
     * Program constructor
     *
     * @param Instruction[] $instructions
     */
    public function __construct(array $instructions)
    {
        $this->instructions = $instructions;
    }

    /**
     * {@inheritdoc}
     */
    public function current(): ?Instruction
    {
        return current($this->instructions);
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        return next($this->instructions);
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return key($this->instructions);
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return key($this->instructions) !== null;
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        reset($this->instructions);
    }
}
