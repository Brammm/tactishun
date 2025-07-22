<?php

declare(strict_types=1);

namespace Brammm\CommandBus;

use Brammm\CommandBus\Resolver\AttributeCommandHandlerResolver;
use Brammm\CommandBus\Resolver\CommandHandlerResolver;
use Psr\Container\ContainerInterface;
use RuntimeException;

final readonly class CommandBus
{
    public function __construct(
        private ContainerInterface $container,
        private CommandHandlerResolver $commandHandlerResolver = new AttributeCommandHandlerResolver(),
    ) {
    }

    public function handle(object $command): void
    {
        $handler = $this->container->get(
            $this->commandHandlerResolver->resolve($command),
        );

        if (! $handler instanceof CommandHandler) {
            throw new RuntimeException('Not a valid CommandHandler');
        }

        $handler->handle($command);
    }
}
