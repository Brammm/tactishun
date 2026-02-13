<?php

declare(strict_types=1);

namespace Brammm\Tactishun\Resolver;

use Brammm\Tactishun\HandlerFor;
use Brammm\Tactishun\Resolver\CommandHandlerResolver;
use Brammm\Tactishun\Resolver\HandlerNotFound;
use ReflectionClass;
use ReflectionException;

final class HandlerForResolver implements CommandHandlerResolver
{

    private array $commandHandlers;

    /**
     * @param class-string<CommandHandler>[] $commandHandlers
     */
    public function __construct(string ...$commandHandlers) {
        $this->commandHandlers = $commandHandlers;
    }

    public function resolve(object $command) : string
    {
        $bestMatch = null;
        foreach ($this->commandHandlers as $i => $handlerClassname) {
            try {
                foreach (new ReflectionClass($handlerClassname)->getAttributes(HandlerFor::class) as $handlerFor) {
                    if (in_array($command, $handlerFor->newInstance()->commands)) {
                        return $handlerClassname;
                    }

                    foreach ($handlerFor->newInstance()->commands as $handlableCommand) {
                        if ($command === $handlableCommand) {
                          return $handlerClassname;
                        }
                        if (empty($bestMatch) && is_a($command, $handlableCommand, true)) {
                          $bestMatch = $handlerClassname;
                        }
                    }
                }
            } catch (ReflectionException $e) {
                // don't try this one again next time
                unset($this->commandHandlers[$i]);
            }
        }

        return $bestMatch ?? throw new HandlerNotFound($command::class);
    }
}
