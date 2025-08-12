<?php

declare(strict_types=1);

namespace Brammm\Tactishun\Tests\TestImplementations;

final class FooCommand
{
    public function __construct(
        public string $name,
    ) {
    }
}
