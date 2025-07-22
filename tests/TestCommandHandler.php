<?php

declare(strict_types=1);

namespace Brammm\CommandBus\Tests;

use Brammm\CommandBus\CommandHandler;

use function file_put_contents;

/** @implements CommandHandler<TestCommand> */
final class TestCommandHandler implements CommandHandler
{
    public function handle(object $command): void
    {
        file_put_contents(__DIR__ . '/test.txt', $command->name);
    }
}
