# Ghoori Package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/dotlines-io/ghoori.svg?style=flat-square)](https://packagist.org/packages/dotlines-io/ghoori)
[![Tests](https://github.com/dotlines-io/ghoori/actions/workflows/run-tests.yml/badge.svg)](https://github.com/dotlines-io/ghoori/actions/workflows/run-tests.yml)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/dotlines-io/ghoori/Check%20&%20fix%20styling?label=code%20style)](https://github.com/dotlines-io/ghoori/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amaster)
[![Psalm](https://github.com/dotlines-io/ghoori/actions/workflows/psalm.yml/badge.svg)](https://github.com/dotlines-io/ghoori/actions/workflows/psalm.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/dotlines-io/ghoori.svg?style=flat-square)](https://packagist.org/packages/dotlines-io/ghoori)

---

This composer package can be used for Payment API Authentication & Authorization with [Ghoori](http://ghoori.com.bd) Platform.
For the credentials, please contact with support@ghoori.com.bd or call 8809612332215

## Installation

You can install the package via composer:

```bash
composer require dotlines-io/ghoori
```

## Usage

```php
/**
 * ******************************************************
 * ******************* Token Fetching *******************
 * *********** Contact Ghoori For Credentials ***********
 * ******************************************************
 */
$tokenUrl = 'https://<SERVER_URL>/oauth/token';
$username = '';
$password = '';
$clientID = '';
$clientSecret = '';

$accessTokenRequest = \Dotlines\Ghoori\AccessTokenRequest::getInstance($tokenUrl, $username, $password, $clientID, $clientSecret);
$tokenResponse = $accessTokenRequest->send();
echo json_encode($tokenResponse) . '<br/>';

/**
 * Access Token Request Response looks like below:
 * {
 *  "token_type": "Bearer",
 *  "expires_in": 3600,
 *  "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdW.....",
 *  "refresh_token": "def50200284b2371cad76b4d2a4e24746c44fd6a322....."
 * }
 */

/**
 * Access Token can be cached and reused for 1 hour
 * Before the end of accessToken lifetime every hour
 * you can use the refresh token to fetch new accessToken & refreshToken
 */
$accessToken = $tokenResponse['access_token'];
$refreshToken = $tokenResponse['refresh_token'];

/**
 * ******************************************************
 * ******************* Refresh Token *******************
 * ******************************************************
 */
$refreshTokenRequest = \Dotlines\Ghoori\RefreshTokenRequest::getInstance($tokenUrl, $accessToken, $clientID, $clientSecret, $refreshToken);
$tokenResponse = $refreshTokenRequest->send();
echo json_encode($tokenResponse) . '<br/>';

/**
 * Refresh Token Request Response looks like below:
 * {
 *  "token_type": "Bearer",
 *  "expires_in": 3600,
 *  "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdW.....",
 *  "refresh_token": "def50200284b2371cad76b4d2a4e24746c44fd6a322....."
 * }
 */
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [TareqMahbub](https://github.com/TareqMahbub)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
