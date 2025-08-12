<?php

declare(strict_types=1);

namespace Brammm\Tactishun\Tests\TestImplementations;

use Brammm\Tactishun\CommandHandler\MultipleCommandsHandler;

/** @extends MultipleCommandsHandler<FooCommand|BarCommand> */
final class MultiCommandHandler extends MultipleCommandsHandler
{
    public string|null $foo = null;
    public string|null $bar = null;

    protected function handleFooCommand(FooCommand $command): void
    {
        $this->foo = $command->name;
    }

    protected function handleBarCommand(BarCommand $command): void
    {
        $this->bar = $command->name;
    }
}
