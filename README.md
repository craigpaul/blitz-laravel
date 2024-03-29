# Blitz-Laravel

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Tests][ico-tests]][link-tests]
[![Total Downloads][ico-downloads]][link-downloads]

## Installation

You can install the package via composer:

```bash
composer require craigpaul/blitz-laravel
```

The package will automatically register itself, you will however have to explicitly enable it. To do so, update your `.env` file (or however you are managing environment variables for the environment in question) with the following variable.

```bash
BLITZ_ENABLED=true
```

## Usage

To create a new test case, use the `make:blitz` Artisan command. Tests will be placed within the `tests/Blitz` directory:

```bash
php artisan make:blitz ExampleTest
```

Once the test has been generated, you may begin writing out your workflow using the scaffolded `handle` method.

> [!NOTE]
> Unlike the way you would write multiple test cases with a framework like PHPUnit in Laravel, each class is it's own unique test case (or workflow).

Blitz provides a very fluent (and hopefully familiar) API for making HTTP requests to your application. There are both JSON and non-JSON methods matching all the regular HTTP verbs available for instructing Blitz on what requests to make to your application.

The same _best practices_ you're used to in your everyday Laravel HTTP tests also apply here. You can begin by "setting up the world", meaning to create any seed data you want to exist for your test.

> [!IMPORTANT]
> This data is persisted and used in real time when executing the load tests against your application, so it is advised to model the data and requests based on expected real world usage.

Once you have your data set up, you can move onto making actual requests into your application. This follows the same structure as a typical Laravel HTTP test by calling methods such as `get`, `post`, `put`, `patch`, or `delete` (or their JSON counterparts).

Thats all there really is to setting up a basic load test with Blitz. From here, you will want to sign into your running instance of the Blitz UI (local or hosted) and set up the project to begin executing your load tests against whatever environment you desire.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

```base
composer test
```

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) and [CONDUCT](.github/CODE_OF_CONDUCT.md) for details.

## Security Vulnerabilities

Please review our [security policy](.github/SECURITY.md) on how to report security vulnerabilities.

## Credits

- [Craig Paul][link-author-paul]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [LICENSE](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/craigpaul/blitz-laravel.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-tests]: https://img.shields.io/github/workflow/status/craigpaul/blitz-laravel/tests/main?label=tests&style=flat-square
[ico-style-ci]: https://styleci.io/repos/80351847/shield?branch=main
[ico-downloads]: https://img.shields.io/packagist/dt/craigpaul/blitz-laravel.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/craigpaul/blitz-laravel
[link-tests]: https://github.com/craigpaul/blitz-laravel/actions?query=workflow%3Atests
[link-style-ci]: https://styleci.io/repos/80351847
[link-downloads]: https://packagist.org/packages/craigpaul/blitz-laravel
[link-author-paul]: https://github.com/craigpaul
[link-contributors]: ../../contributors
