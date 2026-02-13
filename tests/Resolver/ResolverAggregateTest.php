<?php

declare(strict_types=1);

namespace Brammm\Tactishun\Tests\Resolver;

use Brammm\Tactishun\Resolver\HandledByCommandHandlerResolver;
use Brammm\Tactishun\Resolver\HandlerForResolver;
use Brammm\Tactishun\Resolver\HandlerNotFound;
use Brammm\Tactishun\Resolver\ResolverAggregate;
use Brammm\Tactishun\Tests\TestImplementations\Command;
use Brammm\Tactishun\Tests\TestImplementations\CommandHandler;
use Brammm\Tactishun\Tests\TestImplementations\CommandHandlerFor;
use Brammm\Tactishun\Tests\TestImplementations\CommandWithoutAttribute;
use PHPUnit\Framework\TestCase;

final class ResolverAggregatetest extends TestCase
{
    public function testItResolvesRegisteredCommand(): void
    {
        $resolverA = new HandledByCommandHandlerResolver();
        $resolverB = new HandlerForResolver(CommandHandlerFor::class);
        $aggregateResolver = new ResolverAggregate($resolverA, $resolverB);
        $handlerA = $aggregateResolver->resolve(new Command('John'));
        $handlerB = $aggregateResolver->resolve(new CommandWithoutAttribute('Jerry'));

        self::assertEquals(CommandHandler::class, $handlerA);
        self::assertEquals(CommandHandlerFor::class, $handlerB);
    }

    public function testItThrowsExceptionIfCommandNotRegistered(): void
    {
        $resolver = new HandlerForResolver(CommandHandlerFor::class);

        $this->expectException(HandlerNotFound::class);
        $resolver->resolve(new Command('Jerry'));
    }
}
