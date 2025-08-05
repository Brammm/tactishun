<?php

declare(strict_types=1);

namespace Brammm\Tactishun\Tests\TestImplementations;

use Brammm\Tactishun\CommandHandler as CommandHandlerInterface;
use Brammm\Tactishun\HandlerFor;

/**
 * @implements CommandHandlerInterface<Command>
 * @implements CommandHandlerInterface<CommandWithoutAttribute>
 */
#[HandlerFor(CommandWithoutAttribute::class)]
final class CommandHandlerFor implements CommandHandlerInterface
{
    public string|null $name = null;

    public function handle(object $command): void
    {
        $this->name = $command->name;
    }
}
