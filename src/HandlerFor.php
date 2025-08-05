<?php

declare(strict_types=1);

namespace Brammm\Tactishun;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
final class HandlerFor
{
    public final array $commands;

    /**
     * @param class-string $commands
     */
    public function __construct(string ...$commands)
    {
        $this->commands = $commands;
    }
}
