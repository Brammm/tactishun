<?php

declare(strict_types=1);

namespace Brammm\Tactishun;

use Brammm\Tactishun\Middleware\Middleware;
use Brammm\Tactishun\Resolver\CommandHandlerResolver;
use Brammm\Tactishun\Resolver\HandledByCommandHandlerResolver;
use InvalidArgumentException;
use Psr\Container\ContainerInterface;

use function count;

final class CommandBus
{
    /** @var list<Middleware>  */
    private array $middlewares = [];

    public function __construct(
        private readonly ContainerInterface $container,
        private readonly CommandHandlerResolver $commandHandlerResolver = new HandledByCommandHandlerResolver(),
    ) {
    }

    public function handle(object $command): void
    {
        $handler = $this->container->get(
            $this->commandHandlerResolver->resolve($command),
        );

        if (! $handler instanceof CommandHandler) {
            throw new InvalidArgumentException('Not a valid CommandHandler');
        }

        $tip = $handler;

        // Build chain in reverse order (last middleware added wraps first)
        for ($i = count($this->middlewares) - 1; $i >= 0; $i--) {
            $middleware = $this->middlewares[$i];
            $next       = $tip;
            $tip        = new readonly class ($middleware, $next) implements CommandHandler {
                /**
                 * @phpstan-param CommandHandler<T> $next
                 *
                 * @template T of object
                 */
                public function __construct(
                    private Middleware $middleware,
                    private CommandHandler $next,
                ) {
                }

                public function handle(object $command): void
                {
                    $this->middleware->process($command, $this->next);
                }
            };
        }

        $tip->handle($command);
    }

    public function add(Middleware $middleware): void
    {
        $this->middlewares[] = $middleware;
    }
}
