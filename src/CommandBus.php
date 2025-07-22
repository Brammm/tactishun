<?php

declare(strict_types=1);

namespace Brammm\CommandBus;

use Brammm\CommandBus\Tests\TestCommand;
use Brammm\CommandBus\Tests\TestCommandHandler;

use function assert;

final class CommandBus
{
    public function handle(object $command): void
    {
        $handler = new TestCommandHandler();
        assert($command instanceof TestCommand);
        $handler->handle($command);
    }
}
