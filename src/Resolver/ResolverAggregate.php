<?php

declare(strict_types=1);

namespace Brammm\Tactishun\Resolver;

use Brammm\Tactishun\Resolver\CommandHandlerResolver;
use Brammm\Tactishun\Resolver\HandlerNotFound;

final class ResolverAggregate implements CommandHandlerResolver
{

    private array $resolvers;

    /**
     * @param CommandHandlerResolver[] $resolvers
     */
    public function __construct(CommandHandlerResolver ...$resolvers)
    {
        $this->resolvers = $resolvers;
    }

    public function resolve(object $command) : string
    {
        foreach ($this->resolvers as $resolver) {
            try {
                return $resolver->resolve($command);
            } catch (HandlerNotFound) {
                // continue
            }
        }
        throw new HandlerNotFound($command::class);
    }
}
