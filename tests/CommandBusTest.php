<?php

declare(strict_types=1);

namespace Brammm\CommandBus\Tests;

use Brammm\CommandBus\CommandBus;
use PHPUnit\Framework\TestCase;

use function file_get_contents;
use function unlink;

final class CommandBusTest extends TestCase
{
    public function testItHandlesACommand(): void
    {
        $command = new TestCommand('John');

        $commandBus = new CommandBus();
        $commandBus->handle($command);

        $contents = file_get_contents(__DIR__ . '/test.txt');
        self::assertEquals('John', $contents);
        unlink(__DIR__ . '/test.txt');
    }
}
