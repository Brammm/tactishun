<?php

declare(strict_types=1);

namespace Brammm\Tactishun\Tests\TestImplementations;

use Brammm\Tactishun\HandledBy;

/** @phpstan-ignore argument.type (Ignoring for testing purposes) */
#[HandledBy(NotACommandHandler::class)]
final class CommandWithNotACommandHandler
{
}
