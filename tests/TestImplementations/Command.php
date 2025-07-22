<?php

declare(strict_types=1);

namespace Brammm\CommandBus\Tests\TestImplementations;

use Brammm\CommandBus\HandledBy;

#[HandledBy(CommandHandler::class)]
final class Command
{
    public function __construct(
        public string $name,
    ) {
    }
}
