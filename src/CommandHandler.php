<?php

declare(strict_types=1);

namespace Brammm\CommandBus;

/** @template T of object */
interface CommandHandler
{
    /** @phpstan-param T $command */
    public function handle(object $command): void;
}
