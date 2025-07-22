<?php

declare(strict_types=1);

namespace Brammm\Tactishun\Tests\TestImplementations;

use Exception;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

use function array_key_exists;

final class Container implements ContainerInterface
{
    /** @var array<string, object> */
    private array $classes;

    public function __construct()
    {
        $this->classes = [
            CommandHandler::class => new CommandHandler(),
            NotACommandHandler::class => new NotACommandHandler(),
        ];
    }

    /**
     * @return ($id is class-string<T> ? T : mixed)
     *
     * @template T
     */
    public function get(string $id): mixed
    {
        if (! $this->has($id)) {
            throw new class () extends Exception implements NotFoundExceptionInterface {
            };
        }

        return $this->classes[$id];
    }

    public function has(string $id): bool
    {
        return array_key_exists($id, $this->classes);
    }
}
