# phisch90/oauth-server

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]


## Things to implement
This repository will implement multiple popular RFC's to provide as much OAuth functionality as possible. Once fully implemented, RFC's other than 6749 will be extracted into separate repositories, so a developer might only use what he needs.

### RFC 6749
The basic RFC6749 will be fully implemented in this repository.

 - Authorization Server
   - [ ] Authorization Endpoint
   - [ ] Token Endpoint
   - [ ] Redirection Endpoint
 - Resource Owner
 - Resource Server

## Install

Via Composer

``` bash
$ composer require phisch90/oauth-server:dev-master
```

## Security

If you discover any security related issues, please email oauthserver@philippschaffrath.de instead of using the issue tracker.

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.

[ico-version]: https://img.shields.io/packagist/v/phisch90/oauth-server.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/phisch90/oauth-server/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/phisch90/oauth-server.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/phisch90/oauth-server.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/phisch90/oauth-server.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/phisch90/oauth-server
[link-travis]: https://travis-ci.org/phisch90/oauth-server
[link-scrutinizer]: https://scrutinizer-ci.com/g/phisch90/oauth-server/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/phisch90/oauth-server
[link-downloads]: https://packagist.org/packages/phisch90/oauth-server
[link-author]: https://github.com/PhilippSchaffrath