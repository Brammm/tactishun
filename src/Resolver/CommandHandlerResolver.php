<?php

declare(strict_types=1);

namespace Brammm\CommandBus\Resolver;

use Brammm\CommandBus\CommandHandler;

interface CommandHandlerResolver
{
    /**
     * @phpstan-param T $command
     *
     * @return class-string<CommandHandler<T>>
     *
     * @template T of object
     */
    public function resolve(object $command): string;
}
