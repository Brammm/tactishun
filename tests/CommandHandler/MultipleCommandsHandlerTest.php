<?php

declare(strict_types=1);

namespace Brammm\Tactishun\Tests\CommandHandler;

use BadFunctionCallException;
use Brammm\Tactishun\Tests\TestImplementations\BarCommand;
use Brammm\Tactishun\Tests\TestImplementations\BazCommand;
use Brammm\Tactishun\Tests\TestImplementations\FooCommand;
use Brammm\Tactishun\Tests\TestImplementations\MultiCommandHandler;
use PHPUnit\Framework\TestCase;

final class MultipleCommandsHandlerTest extends TestCase
{
    public function testItAllowsASingleCommandHandlerToHandleMultipleCommands(): void
    {
        $handler = new MultiCommandHandler();

        $handler->handle(new FooCommand('John'));
        $handler->handle(new BarCommand('Jane'));

        self::assertEquals('John', $handler->foo);
        self::assertEquals('Jane', $handler->bar);
    }

    public function testItThrowsLogicExceptionIfHandlerIsNotPresent(): void
    {
        $handler = new MultiCommandHandler();

        $this->expectException(BadFunctionCallException::class);
        $handler->handle(new BazCommand()); // @phpstan-ignore argument.type (We are causing an exception)
    }
}
