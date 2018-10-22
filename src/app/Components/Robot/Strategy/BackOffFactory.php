<?php

namespace App\Components\Robot\Strategy;

use App\Components\Robot\Program;
use App\Components\Robot\Strategy;
use App\Components\Robot\StrategyInterface;

/**
 * Class BackOffFactory
 *
 * @package App\Components\Robot\Strategy
 */
class BackOffFactory
{
    /**
     * @return StrategyInterface
     */
    public function create(): StrategyInterface
    {
        return new Strategy(
            new Program([
                Program\Instruction::turnRight(),
                Program\Instruction::advance()
            ]),
            new Strategy(
                new Program([
                    Program\Instruction::turnLeft(),
                    Program\Instruction::back(),
                    Program\Instruction::turnRight(),
                    Program\Instruction::advance()
                ]),
                new Strategy(
                    new Program([
                        Program\Instruction::turnLeft(),
                        Program\Instruction::turnLeft(),
                        Program\Instruction::advance()
                    ]),
                    new Strategy(
                        new Program([
                            Program\Instruction::turnRight(),
                            Program\Instruction::back(),
                            Program\Instruction::turnRight(),
                            Program\Instruction::advance()
                        ]),
                        new Strategy(
                            new Program([
                                Program\Instruction::turnLeft(),
                                Program\Instruction::turnLeft(),
                                Program\Instruction::advance()
                            ])
                        )
                    )
                )
            )
        );
    }
}