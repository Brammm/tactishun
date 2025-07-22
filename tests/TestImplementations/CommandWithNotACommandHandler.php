<?php

declare(strict_types=1);

namespace Brammm\CommandBus\Tests\TestImplementations;

use Brammm\CommandBus\HandledBy;

/** @phpstan-ignore argument.type (Ignoring for testing purposes) */
#[HandledBy(NotACommandHandler::class)]
final class CommandWithNotACommandHandler
{
}
