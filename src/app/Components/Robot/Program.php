<?php

namespace App\Components\Robot;

use App\Components\Robot\Program\Instruction;

use App\Components\Robot\Program\Exception as ProgramException;

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
     * @param string[] $instructions
     *
     * @throws ProgramException
     */
    public function __construct(array $instructions)
    {
        foreach ($instructions as $instruction) {
            if (!Instruction::isValid($instruction)) {
                throw new ProgramException("Invalid instruction \"$instruction\"");
            }
        }

        $this->instructions = $instructions;
    }

    /**
     * @param int $row
     * @param int $column
     *
     * @return null|string
     */
    public function getCell(int $row, int $column): ?string
    {
        return $this->data[$row][$column] ?? null;
    }

    /**
     * {@inheritdoc}
     */
    public function current()
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
