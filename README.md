<p align="center">
    <a href="https://github.com/Jampire/moonshine-impersonate/actions/workflows/build.yml" target="_blank" title="build"><img src="https://github.com/Jampire/moonshine-impersonate/actions/workflows/build.yml/badge.svg?branch=master" alt="build"></a>
    <a href="https://packagist.org/packages/Jampire/moonshine-impersonate" target="_blank" title="download"><img src="https://img.shields.io/packagist/dt/Jampire/moonshine-impersonate?style=flat-square" alt="downloads"></a>
    <a href="https://github.com/Jampire/moonshine-impersonate/blob/master/LICENSE" target="_blank" title="license"><img src="https://img.shields.io/github/license/Jampire/moonshine-impersonate?style=flat-square" alt="license"></a>
    <a href="https://github.com/Jampire/moonshine-impersonate/releases" target="_blank" title="release"><img src="https://img.shields.io/github/v/release/Jampire/moonshine-impersonate?display_name=tag&sort=semver&style=flat-square" alt="release"></a>
    <a href="https://packagist.org/packages/Jampire/moonshine-impersonate" target="_blank" title="php"><img src="https://img.shields.io/packagist/php-v/Jampire/moonshine-impersonate?style=flat-square" alt="composer"></a>
    <a href="https://github.com/Jampire/moonshine-impersonate/graphs/contributors" target="_blank" title="contributors"><img src="https://img.shields.io/github/contributors/Jampire/moonshine-impersonate?style=flat-square" alt="contributors"></a>
    <a href="https://github.com/Jampire/moonshine-impersonate/issues" target="_blank" title="welcome"><img src="https://img.shields.io/badge/contributions-welcome-brightgreen.svg?style=flat-square" alt="contributors"></a>
</p>

# User Impersonation for MoonShine admin panel

## Introduction

This package provides Impersonation (user switch) capability to [MoonShine][1] admin panel. User Impersonation allows
Administrators to access and operate as if they were logged in as that User. This is handy for many reasons,
for example, when you get a bug report or an issue and want to see exactly what the user sees, impersonating them
saves lots of time because you can see exactly what they see.

## Installation

Use `composer` to install `MoonShine Impersonate` package:
```shell
composer require jampire/moonshine-impersonate
```

This package is designed to work in MoonShine only. You first need to install it. Please, read
[the documentation][2] on how install and configure MoonShine.

## Configuration

This package works out of the box with default configuration. But you can publish `impersonate.php` config file
and tweak it to your desire:

```shell
php artisan vendor:publish --provider="Jampire\MoonshineImpersonate\ImpersonateServiceProvider" --tag=config
```

## Usage

You can find the package documentation [here][3].

## Contributing

Thank you for considering contributing to `MoonShine Impersonate` project! You can read the contribution guide [here][4].

## Code of Conduct
Please review and abide by the [Code of Conduct][5].

## Credits

- [Dzianis Kotau][6]
- [All Contributors][7]

## License
`MoonShine Impersonate` is open-sourced software licensed under the [MIT license][8].

## Other implementations
- [Laravel Nova impersonation mode][9]
- [Laravel Orchid impersonation mode][10]
- [Laravel standalone package][11]

[1]: https://moonshine.cutcode.dev/
[2]: https://moonshine.cutcode.dev/section/installation
[3]: https://dzianiskotau.com/moonshine-impersonate/
[4]: CONTRIBUTING.md
[5]: CODE_OF_CONDUCT.md
[6]: https://github.com/Jampire
[7]: https://github.com/Jampire/moonshine-impersonate/graphs/contributors
[8]: LICENSE
[9]: https://nova.laravel.com/docs/4.0/customization/impersonation.html
[10]: https://orchid.software/en/docs/access/#user-impersonation
[11]: https://laravel-news.com/laravel-impersonate
