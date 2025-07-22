<?php

declare(strict_types=1);

namespace Brammm\CommandBus\Tests;

use Brammm\CommandBus\CommandBus;
use Brammm\CommandBus\Tests\TestImplementations\Command;
use Brammm\CommandBus\Tests\TestImplementations\CommandHandler;
use Brammm\CommandBus\Tests\TestImplementations\Container;
use PHPUnit\Framework\TestCase;

final class CommandBusTest extends TestCase
{
    public function testItHandlesACommand(): void
    {
        $container = new Container();

        self::assertNull($container->get(CommandHandler::class)->name);

        $command = new Command('John');

        $commandBus = new CommandBus(
            $container,
        );
        $commandBus->handle($command);

        self::assertEquals('John', $container->get(CommandHandler::class)->name);
    }
}
