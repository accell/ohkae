# Ohkae

[![Latest Version](https://img.shields.io/github/release/accell/ohkae.svg?style=flat-square)](https://github.com/accell/ohkae/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/accell/ohkae/master.svg?style=flat-square)](https://travis-ci.org/accell/ohkae)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/accell/ohkae.svg?style=flat-square)](https://scrutinizer-ci.com/g/accell/ohkae/code-structure)
[![Total Downloads](https://img.shields.io/packagist/dt/accell/ohkae.svg?style=flat-square)](https://packagist.org/packages/accell/ohkae)

Check HTML for common accessibility issues; do what you want with the data that's returned

## Install

Via Composer (don't actually do this right now)

``` bash
$ composer require accell/ohkae
```

## Usage

``` php
$html   = file_get_contents('test.html');
$report = (new Ohkae($html, 'wcag', null, null))->runReport();
```

## Testing

``` bash
$ phpunit
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email me@ericcolon.com instead of using the issue tracker.

## Credits

- [Eric Colón](https://github.com/accell)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
