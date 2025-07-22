<?php

declare(strict_types=1);

namespace Brammm\Tactishun\Middleware;

use Brammm\Tactishun\CommandHandler;

interface Middleware
{
    /**
     * @param T                 $command
     * @param CommandHandler<T> $commandHandler
     *
     * @template T of object
     */
    public function process(object $command, CommandHandler $commandHandler): void;
}
