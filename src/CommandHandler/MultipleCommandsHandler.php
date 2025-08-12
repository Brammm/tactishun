<?php

declare(strict_types=1);

namespace Brammm\Tactishun\CommandHandler;

use BadFunctionCallException;
use ReflectionClass;

use function is_callable;
use function sprintf;

/**
 * @template T of object
 * @implements CommandHandler<T>
 */
abstract class MultipleCommandsHandler implements CommandHandler
{
    public function handle(object $command): void
    {
        $reflectionClass = new ReflectionClass($command);
        $shortName       = $reflectionClass->getShortName();

        $callable = [$this, 'handle' . $shortName];

        if (! is_callable($callable)) {
            throw new BadFunctionCallException(sprintf('No callable found for command %s', $shortName));
        }

        $callable($command);
    }
}
