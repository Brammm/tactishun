# Tactishun

[![PHP Version][ico-php]][link-php]
[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build status][ico-build]][link-build]

A lightweight command bus implementation for PHP 8.1+ projects, designed to provide a
straightforward approach to hexagonal architecture and CQRS patterns.

## Features

- Simple command bus pattern implementation
- PSR-11 container integration
- Extensible middleware system
- Zero configuration required to get started
- Full PHPStan coverage

## Installation

Install via Composer:

```bash
composer require brammm/tactishun
```

## Quickstart

```php
use Brammm\Tactishun\CommandBus;
use Brammm\Tactishun\HandledBy;
use Brammm\Tactishun\CommandHandler;

// 1. Create your command
#[HandledBy(SendWelcomeMailHandler::class)]
final readonly class SendWelcomeMail
{
    public function __construct(
        public UserId $userId,
    ) {}
}

// 2. Implement the handler
/** @implements CommandHandler<SendWelcomeMail> */
final class SendWelcomeMailHandler implements CommandHandler
{
    public function handle(object $command): void
    {
        // Fetch user from $command->userId and send welcome email
    }
}

// 3. Set up the command bus
$container = new Container(); // Any PSR-11 compatible container
$commandBus = new CommandBus($container);

// 4. Dispatch commands
$commandBus->handle(new SendWelcomeMail($user->id));
```

## Extending functionality

### Middleware

Extend functionality with middleware that wraps command execution:

```php
final readonly class LoggingMiddleware implements Middleware
{
    public function __construct(
        private LoggerInterface $logger
    ) {}

    public function process(object $command, CommandHandler $commandHandler): void
    {
        $commandName = get_class($command);
        $this->logger->info("Executing command: {$commandName}");

        $startTime = microtime(true);
        $commandHandler->handle($command);
        $executionTime = microtime(true) - $startTime;

        $this->logger->info("Command {$commandName} completed in {$executionTime}ms");
    }
}

// Register middleware
$commandBus->add(new LoggingMiddleware($logger));
```

Middleware are added First In, First Out.

Through Middleware, it is possible to provide async queued functionality. No Middleware to
facilitate this are shipped with this package at the moment.

### Custom `CommandHandlerResolver`s

By default, Tactishun uses the `AttributeCommandHandlerResolver` to find handlers via the
`HandledBy` attribute. This allows the zero-configuration setup. If you'd rather not use
that attribute or have a different solution in mind, you can provide a custom resolver as
the second parameter:

```php
class ClassMapResolver implements CommandHandlerResolver
{
    private array $handlerMap = [
        SendWelcomeMail::class => SendWelcomeMailHandler::class,
        ProcessPayment::class => ProcessPaymentHandler::class,
    ];

    public function resolve(object $command): string
    {
        $commandClass = get_class($command);
        return $this->handlerMap[$commandClass] ?? throw new HandlerNotFound($commandClass);
    }
}

$commandBus = new CommandBus($container, new ClassMapResolver());
```

Note that command handler resolvers must return a class-string for a command handler that
the container implementation can then resolve to an instance of that handler.

## Inspiration

This library draws inspiration from:

- [Ross Tuck](https://github.com/rosstuck)'s work
  on [league/tactician](https://github.com/thephpleague/tactician)
- The [Slim Framework](https://github.com/slimphp/Slim) middleware dispatcher pattern

[ico-version]: https://img.shields.io/packagist/v/brammm/tactishun.svg?style=flat-square&label=release

[ico-license]: https://img.shields.io/badge/License-LGPLv3-green.svg?style=flat-square

[ico-php]: https://img.shields.io/packagist/dependency-v/brammm/tactishun/php.svg?colorB=%238892BF&style=flat-square

[ico-build]: https://img.shields.io/github/actions/workflow/status/brammm/tactishun/continuous-integration.yml?branch=main&style=flat-square&logo=github

[link-packagist]: https://packagist.org/packages/brammm/tactishun

[link-php]: https://php.net

[link-build]: https://github.com/brammm/tactishun/actions/workflows/continuous-integration.yml
