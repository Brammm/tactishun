# Tactishun

[![Software License][ico-license]](LICENSE.md)

Tactishun is a simple command bus implementation, for use in PHP 8.1 projects or up. Its
aim is to provide a straightforward way of doing hexagonal architecture/CQRS in your
projects.

## Features

- Simple command bus pattern implementation
- PSR-11 container integration
- Attribute-based command-handler mapping
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

## Advanced Usage

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

### Custom Command Handler Resolvers

By default, Tactishun uses the `AttributeCommandHandlerResolver` to find handlers via the
`HandledBy` attribute. You can provide a custom resolver as the second parameter:

## Credits

Thanks to [Ross Tuck](https://github.com/rosstuck) for all his work
on [league/tactician](https://github.com/thephpleague/tactician) and
the [Slim](https://github.com/slimphp/Slim) team. Their MiddlewareDispatcher also inspired
this.

[ico-license]: https://img.shields.io/badge/License-LGPLv3-green.svg?style=flat-square
