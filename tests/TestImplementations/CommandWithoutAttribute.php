<?php

declare(strict_types=1);

namespace Brammm\Tactishun\Tests\TestImplementations;

final readonly class CommandWithoutAttribute
{
    public function __construct(
        public string $name,
    ) {
    }
}
