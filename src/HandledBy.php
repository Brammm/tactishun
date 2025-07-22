<?php

declare(strict_types=1);

namespace Brammm\CommandBus;

use Attribute;

#[Attribute]
final class HandledBy
{
    /**
     * @param class-string<T> $commandHandler
     *
     * @template T of CommandHandler
     */
    public function __construct(
        public string $commandHandler,
    ) {
    }
}
