<?php

declare(strict_types=1);

namespace Brammm\Tactishun\Tests\Resolver;

use Brammm\Tactishun\Resolver\HandlerNotFound;
use Brammm\Tactishun\Resolver\HandlesCommandHandlerResolver;
use Brammm\Tactishun\Tests\TestImplementations\Command;
use Brammm\Tactishun\Tests\TestImplementations\CommandWithoutAttribute;
use Brammm\Tactishun\Tests\TestImplementations\HandlesCommandHandler;
use PHPUnit\Framework\TestCase;

final class HandlesCommandHandlerResolverTest extends TestCase
{
    public function testItResolvesTheCommandHandlerClassString(): void
    {
        $resolver = new HandlesCommandHandlerResolver([
            HandlesCommandHandler::class,
        ]);
        $handler  = $resolver->resolve(new CommandWithoutAttribute('John'));

        self::assertEquals(HandlesCommandHandler::class, $handler);
    }

    public function testItThrowsExceptionIfCantFindCommandHandler(): void
    {
        $resolver = new HandlesCommandHandlerResolver([
            HandlesCommandHandler::class,
        ]);

        $this->expectException(HandlerNotFound::class);
        $resolver->resolve(new Command('John'));
    }
}
