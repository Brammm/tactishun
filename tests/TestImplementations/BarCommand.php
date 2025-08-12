<?php

declare(strict_types=1);

namespace Brammm\Tactishun\Tests\TestImplementations;

final class BarCommand
{
    public function __construct(
        public string $name,
    ) {
    }
}
