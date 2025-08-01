<?php

declare(strict_types=1);

namespace Brammm\Tactishun\Resolver;

use Brammm\Tactishun\HandledBy;
use ReflectionClass;

final readonly class AttributeCommandHandlerResolver implements CommandHandlerResolver
{
    public function resolve(object $command): string
    {
        $reflection = new ReflectionClass($command);
        $attributes = $reflection->getAttributes(HandledBy::class);

        if ($attributes === []) {
            throw new MissingHandledByAttribute($command::class);
        }

        return $attributes[0]->newInstance()->commandHandler;
    }
}
