<?php

declare(strict_types=1);

namespace Brammm\Tactishun\Tests\Resolver;

use Brammm\Tactishun\Resolver\HandlerForResolver;
use Brammm\Tactishun\Resolver\HandlerNotFound;
use Brammm\Tactishun\Tests\TestImplementations\Command;
use Brammm\Tactishun\Tests\TestImplementations\CommandHandlerFor;
use Brammm\Tactishun\Tests\TestImplementations\CommandWithoutAttribute;
use PHPUnit\Framework\TestCase;

final class HandlerForResolverTest extends TestCase
{
    public function testItResolvesRegisteredCommand(): void
    {
        $resolver = new HandlerForResolver(CommandHandlerFor::class);
        $handler  = $resolver->resolve(new CommandWithoutAttribute('Jerry'));

        self::assertEquals(CommandHandlerFor::class, $handler);
    }

    public function testItThrowsExceptionIfCommandNotRegistered(): void
    {
        $resolver = new HandlerForResolver(CommandHandlerFor::class);

        $this->expectException(HandlerNotFound::class);
        $resolver->resolve(new Command('Jerry'));
    }
}
