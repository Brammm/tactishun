<?php

declare(strict_types=1);

namespace Brammm\Tactishun\Tests\TestImplementations;

use Brammm\Tactishun\HandledBy;

#[HandledBy(CommandHandler::class)]
final class Command
{
    public function __construct(
        public string $name,
    ) {
    }
}
