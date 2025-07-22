<?php

declare(strict_types=1);

namespace Brammm\CommandBus\Resolver;

use Brammm\CommandBus\HandledBy;
use ReflectionClass;
use RuntimeException;

final readonly class AttributeCommandHandlerResolver implements CommandHandlerResolver
{
    public function resolve(object $command): string
    {
        $reflection = new ReflectionClass($command);
        $attributes = $reflection->getAttributes(HandledBy::class);

        if ($attributes === []) {
            throw new RuntimeException('No attribute defined');
        }

        return $attributes[0]->newInstance()->commandHandler;
    }
}
