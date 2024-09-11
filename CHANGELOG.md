# Changelog

## [Unreleased]

## [0.5.1] - 2024-09-11

### Fixed

- Fixes missing mock expectation [`3718d86131`](https://github.com/craigpaul/blitz-laravel/commit/3718d86131)

## [0.5.0] - 2024-09-11

### Added

- Adds support for supplying customizable fields in a given workflow/run [`0972f43a37`](https://github.com/craigpaul/blitz-laravel/commit/0972f43a37)

## [0.4.3] - 2024-09-10

### Fixed

- Fixes missed namespace update [`e9b88eef6c`](https://github.com/craigpaul/blitz-laravel/commit/e9b88eef6c)

## [0.4.2] - 2024-09-10

### Added

- Passes current request instance into test [`b192d4ec6d`](https://github.com/craigpaul/blitz-laravel/commit/b192d4ec6d)

## [0.4.1] - 2024-09-09

### Fixed

- Fixes non-compliant PSR-4 namespace [`1db519b115`](https://github.com/craigpaul/blitz-laravel/commit/1db519b115)

## [0.4.0] - 2024-08-26

### Added

- Adds ability to set a user to act as for a given set of requests [`5651c525ac`](https://github.com/craigpaul/blitz-laravel/commit/5651c525ac)

## [0.3.0] - 2024-01-04

### Added

- Adds ability to provide histogram buckets for response grouping within the Blitz UI [`34d1fbc5a2`](https://github.com/craigpaul/blitz-laravel/commit/34d1fbc5a2)

## [0.2.0] - 2023-11-26

### Changed

- Changes conventional method name from setUp to handle to avoid potential confusion with linters confusing it for a PHPUnit test [`2f7674bba4`](https://github.com/craigpaul/blitz-laravel/commit/2f7674bba4)

### Fixed

- Updates incorrect link in README [`59f29208c3`](https://github.com/craigpaul/blitz-laravel/commit/59f29208c3)

## [0.1.1] - 2023-11-26

### Added

- Adds docblock to stub file for describing the singular method in a Blitz test [`57d84c52e8`](https://github.com/craigpaul/blitz-laravel/commit/57d84c52e8)

### Fixed

- Replaces incorrect method of utilizing a configuration file with the one that allows for users to access it as default [`f043ec095b`](https://github.com/craigpaul/blitz-laravel/commit/f043ec095b)

## [0.1.0] - 2023-11-26

### Added

- Adds high level overview of how to use Blitz for writing a load test [`8fc6644f83`](https://github.com/craigpaul/blitz-laravel/commit/8fc6644f83)
- Adds docblock describing new configuration option [`d8185ee8c8`](https://github.com/craigpaul/blitz-laravel/commit/d8185ee8c8)
- Updates README with instruction on how to enable Blitz [`e29afd7dce`](https://github.com/craigpaul/blitz-laravel/commit/e29afd7dce)
- Adds configuration file to control enabling and disabling Blitz access [`21738b8c84`](https://github.com/craigpaul/blitz-laravel/commit/21738b8c84)
- Adds Github workflow file for running automated tests against various PHP/Laravel versions [`1b3fa8ad3b`](https://github.com/craigpaul/blitz-laravel/commit/1b3fa8ad3b)
- Adds initial README and CHANGELOG files [`5c5b13b7a3`](https://github.com/craigpaul/blitz-laravel/commit/5c5b13b7a3)
- Adds abstract test case that will be used by downstream consumers for setting up their load test workflows [`00aab9eacf`](https://github.com/craigpaul/blitz-laravel/commit/00aab9eacf)
- Enables the command to run when running in console [`3a60732620`](https://github.com/craigpaul/blitz-laravel/commit/3a60732620)
- Adds command and stub for generating a Blitz load test in the correct place [`1604df8c75`](https://github.com/craigpaul/blitz-laravel/commit/1604df8c75)
- Adds test cases for generating a test file using an artisan command [`deb4bb3cf8`](https://github.com/craigpaul/blitz-laravel/commit/deb4bb3cf8)
- Adds controller logic and route defintion for generating targets based on an existing workflown namespace [`08feb19b4c`](https://github.com/craigpaul/blitz-laravel/commit/08feb19b4c)
- Adds test case for generating targets based on a provided and existing workflow namespace [`c79d375684`](https://github.com/craigpaul/blitz-laravel/commit/c79d375684)
- Adds controller and supporting logic with a route definition for retrieving existing workflow namespaces [`2e0b98dd92`](https://github.com/craigpaul/blitz-laravel/commit/2e0b98dd92)
- Adds test case for retrieving existing workflow namespaces [`d5c922351e`](https://github.com/craigpaul/blitz-laravel/commit/d5c922351e)
- Adds environment setup for test cases [`c6d9e20662`](https://github.com/craigpaul/blitz-laravel/commit/c6d9e20662)
- Adds a phpunit configuration file for upcoming automated tests [`598c62350b`](https://github.com/craigpaul/blitz-laravel/commit/598c62350b)
- Adds src directory PSR-4 compliant autoloading with Laravel specific configuration and ensures the fileinfo extension is present [`2db1cba14e`](https://github.com/craigpaul/blitz-laravel/commit/2db1cba14e)
- Adds base test case with PSR-4 compliant autoloading [`2001044590`](https://github.com/craigpaul/blitz-laravel/commit/2001044590)
- Adds baseline set of dependencies [`4eb9c6f956`](https://github.com/craigpaul/blitz-laravel/commit/4eb9c6f956)
- Adds various GitHub specific template files [`c782a498c1`](https://github.com/craigpaul/blitz-laravel/commit/c782a498c1)
- Adds license file [`bc5a3afb8b`](https://github.com/craigpaul/blitz-laravel/commit/bc5a3afb8b)
- Adds various configuration-based dotfiles [`9a7965ba20`](https://github.com/craigpaul/blitz-laravel/commit/9a7965ba20)
- Initial commit [`de7cfc913c`](https://github.com/craigpaul/blitz-laravel/commit/de7cfc913c)


### Changed

- Reverses name of console command signature to follow popular convention within the framework itself [`5267498b6a`](https://github.com/craigpaul/blitz-laravel/commit/5267498b6a)
- Uses new artisan command to generate a compliant stub during the testing phase instead of having duplicate stubs that could get out of sync [`4735f0745d`](https://github.com/craigpaul/blitz-laravel/commit/4735f0745d)
- Updates example command to use newly decided convention [`797ef1ca7a`](https://github.com/craigpaul/blitz-laravel/commit/797ef1ca7a)

### Fixed

- Fixes cross-version inconsistencies by trimming slashes on the left and right hand side of the namespace at various points in the transformation [`e6c92ecf90`](https://github.com/craigpaul/blitz-laravel/commit/e6c92ecf90)
- Skips test for specific Laravel versions due to functionality not being available [`ed4727eb49`](https://github.com/craigpaul/blitz-laravel/commit/ed4727eb49)
- Downgrades phpunit/phpunit for better compatibility across older versions of other dependencies [`1641f8e68f`](https://github.com/craigpaul/blitz-laravel/commit/1641f8e68f)
- Uses the JSON-specific request method to signify this endpoint is expecting to return JSON [`0dc81cbc83`](https://github.com/craigpaul/blitz-laravel/commit/0dc81cbc83)

### Removed

- Removes unsupported version of PHP from Github workflow [`c5329cbfe9`](https://github.com/craigpaul/blitz-laravel/commit/c5329cbfe9)
