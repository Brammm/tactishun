<?php

declare(strict_types=1);

namespace Brammm\Tactishun\Resolver;

use function sprintf;

final class MissingHandledByAttribute extends HandlerNotFound
{
    /**
     * @param class-string<T> $command
     *
     * @template T of object
     */
    public function __construct(string $command)
    {
        parent::__construct(sprintf('Command "%s" does not have the HandledBy attribute.', $command));
    }
}
