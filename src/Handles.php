<?php

declare(strict_types=1);

namespace Brammm\Tactishun;

use Attribute;

#[Attribute(flags: Attribute::TARGET_CLASS | Attribute::IS_REPEATABLE)]
final class Handles
{
    /**
     * @param class-string<T> $command
     *
     * @template T of object
     */
    public function __construct(
        public string $command,
    ) {
    }
}
