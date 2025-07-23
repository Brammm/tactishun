# ramsey/php-library-starter-kit Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/)
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## 0.2.0 - 2025-07-23

### Added

- License to composer.json
- Code of conduct
- More specific exception for all command handler resolvers.

### Changed

- Now requires at least PHP 8.3

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.

## 0.1.0 - 2025-07-22

Initial release under 0.1.0 as package api might change.

### Added

- Synchronous command bus implementation
- AttributeCommandHandlerResolver that uses a `HandledBy` attribute on commands to map to
  a CommandHandler
- Middleware support

### Changed

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.
