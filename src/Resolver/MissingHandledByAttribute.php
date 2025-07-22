<?php

declare(strict_types=1);

namespace Brammm\CommandBus\Resolver;

use InvalidArgumentException;

final class MissingHandledByAttribute extends InvalidArgumentException
{
    /**
     * @template T of object
     * 
     * @param class-string<T> $command
     */
    public function __construct(string $command)
    {
        parent::__construct(sprintf('Command "%s" does not have the HandledBy attribute.', $command));
    }
}
