<?php

declare(strict_types=1);

namespace Brammm\Tactishun\Tests\TestImplementations;

use Brammm\Tactishun\CommandHandler as CommandHandlerInterface;
use Brammm\Tactishun\Handles;

/** @implements CommandHandlerInterface<Command> */
#[Handles(CommandWithoutAttribute::class)]
final class HandlesCommandHandler implements CommandHandlerInterface
{
    public string|null $name = null;

    public function handle(object $command): void
    {
        $this->name = $command->name;
    }
}
