<?php

declare(strict_types=1);

namespace Brammm\Tactishun\Resolver;

use Brammm\Tactishun\CommandHandler;
use Brammm\Tactishun\Handles;
use ReflectionClass;

use function array_key_exists;
use function array_map;
use function sprintf;

final class HandlesCommandHandlerResolver implements CommandHandlerResolver
{
    /** @var array<class-string, class-string<CommandHandler>> */
    private array $map = [];

    /**
     * @param list<class-string<CommandHandler<T>>> $commandHandlers
     *
     * @template T of object
     */
    public function __construct(array $commandHandlers)
    {
        foreach ($commandHandlers as $commandHandler) {
            foreach ($this->parse($commandHandler) as $commandClass) {
                $this->map[$commandClass] = $commandHandler;
            }
        }
    }

    public function resolve(object $command): string
    {
        $commandClass = $command::class;
        if (! array_key_exists($commandClass, $this->map)) {
            throw new HandlerNotFound(sprintf('Handler not found for command "%s"', $commandClass));
        }

        return $this->map[$commandClass];
    }

    /**
     * @param class-string<CommandHandler<T>> $commandHandler
     *
     * @return list<class-string<T>>
     *
     * @template T of object
     */
    private function parse(string $commandHandler): array
    {
        $reflection = new ReflectionClass($commandHandler);
        $attributes = $reflection->getAttributes(Handles::class);

        return array_map(static fn ($attribute) => $attribute->newInstance()->command, $attributes);
    }
}
