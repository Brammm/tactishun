<?php

declare(strict_types=1);

namespace Brammm\Tactishun\Tests;

use Brammm\Tactishun\CommandBus;
use Brammm\Tactishun\CommandHandler as CommandHandlerInterface;
use Brammm\Tactishun\Middleware\Middleware;
use Brammm\Tactishun\Tests\TestImplementations\Command;
use Brammm\Tactishun\Tests\TestImplementations\CommandHandler;
use Brammm\Tactishun\Tests\TestImplementations\CommandWithNotACommandHandler;
use Brammm\Tactishun\Tests\TestImplementations\Container;
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

    public function testItProcessesMiddleware(): void
    {
        $fooMiddleware = new class implements Middleware {
            public function process(object $command, CommandHandlerInterface $commandHandler): void
            {
                if ($command instanceof Command) {
                    $command->name .= 'Foo';
                }

                $commandHandler->handle($command);
            }
        };
        $barMiddleware = new class implements Middleware {
            public function process(object $command, CommandHandlerInterface $commandHandler): void
            {
                if ($command instanceof Command) {
                    $command->name .= 'Bar';
                }

                $commandHandler->handle($command);
            }
        };

        $this->commandBus->add($fooMiddleware);
        $this->commandBus->add($barMiddleware);

        $this->commandBus->handle(new Command('John'));

        self::assertEquals('JohnFooBar', $this->container->get(CommandHandler::class)->name);
    }
}
