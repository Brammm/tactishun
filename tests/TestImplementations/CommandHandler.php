<?php

declare(strict_types=1);

namespace Brammm\CommandBus\Tests\TestImplementations;

use Brammm\CommandBus\CommandHandler as CommandHandlerInterface;

/** @implements CommandHandlerInterface<Command> */
final class CommandHandler implements CommandHandlerInterface
{
    public string|null $name = null;

    public function handle(object $command): void
    {
        $this->name = $command->name;
    }
}
