<?php

declare(strict_types=1);

namespace Brammm\Tactishun\Tests\Resolver;

use Brammm\Tactishun\Resolver\AttributeCommandHandlerResolver;
use Brammm\Tactishun\Resolver\MissingHandledByAttribute;
use Brammm\Tactishun\Tests\TestImplementations\Command;
use Brammm\Tactishun\Tests\TestImplementations\CommandHandler;
use Brammm\Tactishun\Tests\TestImplementations\CommandWithoutAttribute;
use PHPUnit\Framework\TestCase;

final class AttributeCommandHandlerResolverTest extends TestCase
{
    public function testItResolvesTheCommandHandlerClassString(): void
    {
        $resolver = new AttributeCommandHandlerResolver();
        $handler  = $resolver->resolve(new Command('John'));

        self::assertEquals(CommandHandler::class, $handler);
    }

    public function testItThrowsExceptionIfCommandDoesNotHaveAssertion(): void
    {
        $resolver = new AttributeCommandHandlerResolver();

        $this->expectException(MissingHandledByAttribute::class);
        $resolver->resolve(new CommandWithoutAttribute('John'));
    }
}
