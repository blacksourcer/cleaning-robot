<?php

namespace App\Console;

use App\Console\Commands;

use Laravel\Lumen\Console\Kernel as ConsoleKernel;

/**
 * Class Kernel
 *
 * @package App\Console
 */
class Kernel extends ConsoleKernel
{
    /**
     * @var array
     */
    protected $commands = [
        Commands\Robot\RunCommand::class
    ];
}
