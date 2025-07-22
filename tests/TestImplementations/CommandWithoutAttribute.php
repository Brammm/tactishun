<?php

declare(strict_types=1);

namespace Brammm\CommandBus\Tests\TestImplementations;

final readonly class CommandWithoutAttribute
{
    public function __construct(
        public string $name,
    ) {
    }
}
