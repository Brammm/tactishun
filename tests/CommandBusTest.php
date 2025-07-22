<?php

declare(strict_types=1);

namespace Brammm\CommandBus\Tests;

use Brammm\CommandBus\CommandBus;
use Brammm\CommandBus\Tests\TestImplementations\Command;
use Brammm\CommandBus\Tests\TestImplementations\CommandHandler;
use Brammm\CommandBus\Tests\TestImplementations\CommandWithNotACommandHandler;
use Brammm\CommandBus\Tests\TestImplementations\Container;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class CommandBusTest extends TestCase
{
    private Container $container;
    private CommandBus $commandBus;

    public function setUp(): void
    {
        $this->container  = new Container();
        $this->commandBus = new CommandBus($this->container);
    }

    public function testItHandlesACommand(): void
    {
        self::assertNull($this->container->get(CommandHandler::class)->name);

        $this->commandBus->handle(new Command('John'));

        self::assertEquals('John', $this->container->get(CommandHandler::class)->name);
    }

    public function testItThrowsAnExceptionIfNotAProperCommandHandlerIsResolved(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->commandBus->handle(new CommandWithNotACommandHandler());
    }
}
