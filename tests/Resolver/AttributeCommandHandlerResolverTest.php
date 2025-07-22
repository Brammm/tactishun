<?php

declare(strict_types=1);

namespace Brammm\CommandBus\Tests\Resolver;

use Brammm\CommandBus\Resolver\AttributeCommandHandlerResolver;
use Brammm\CommandBus\Tests\TestImplementations\Command;
use Brammm\CommandBus\Tests\TestImplementations\CommandHandler;
use PHPUnit\Framework\TestCase;

final class AttributeCommandHandlerResolverTest extends TestCase
{
    public function testItResolvesTheCommandHandlerClassString(): void
    {
        $resolver = new AttributeCommandHandlerResolver();
        $handler  = $resolver->resolve(new Command('John'));

        self::assertEquals(CommandHandler::class, $handler);
    }
}
