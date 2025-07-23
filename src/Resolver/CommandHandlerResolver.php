<?php

declare(strict_types=1);

namespace Brammm\Tactishun\Resolver;

use Brammm\Tactishun\CommandHandler;

interface CommandHandlerResolver
{
    /**
     * @phpstan-param T $command
     *
     * @return class-string<CommandHandler<T>>
     *
     * @throws HandlerNotFound
     *
     * @template T of object
     */
    public function resolve(object $command): string;
}
