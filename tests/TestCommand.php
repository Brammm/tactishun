<?php

declare(strict_types=1);

namespace Brammm\CommandBus\Tests;

final class TestCommand
{
    public function __construct(
        public string $name,
    ) {
    }
}
