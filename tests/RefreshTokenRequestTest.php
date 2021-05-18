<?php

/** @noinspection SpellCheckingInspection */
/** @noinspection MethodVisibilityInspection */

namespace Dotlines\Ghoori\Tests;

use Dotlines\Ghoori\AccessTokenRequest;
use Dotlines\Ghoori\RefreshTokenRequest;
use Exception;
use PHPUnit\Framework\TestCase;

class RefreshTokenRequestTest extends TestCase
{
    public string $tokenUrl = 'https://sb-payments.ghoori.com.bd/oauth/token';
    public string $username = 'someUser@gmail.com';
    public string $password = 'Nopass1234';
    public int $clientID = 27;
    public string $clientSecret = 'HmlIb5kqJnA9N9c79E8WzgZ6Hsoh1d5oyMbNruAw';

    /** @test
     * @throws JsonException
     */
    final public function it_can_refresh_access_token(): void
    {
        $accessTokenRequest = AccessTokenRequest::getInstance($this->tokenUrl, $this->username, $this->password, $this->clientID, $this->clientSecret);
        $tokenResponse = $accessTokenRequest->send();

        $accessToken = $tokenResponse['access_token'];
        $refreshToken = $tokenResponse['refresh_token'];

        $refreshTokenRequest = RefreshTokenRequest::getInstance($this->tokenUrl, $accessToken, $this->clientID, $this->clientSecret, $refreshToken);
        $refreshTokenResponse = $refreshTokenRequest->send();

        self::assertNotEmpty($refreshTokenResponse);
        self::assertArrayHasKey('token_type', $refreshTokenResponse);
        self::assertArrayHasKey('expires_in', $refreshTokenResponse);
        self::assertArrayHasKey('access_token', $refreshTokenResponse);
        self::assertArrayHasKey('refresh_token', $refreshTokenResponse);
    }

    /**
     * @test
     */
    final public function it_gets_exception_with_empty_url(): void
    {
        $accessTokenRequest = AccessTokenRequest::getInstance($this->tokenUrl, $this->username, $this->password, $this->clientID, $this->clientSecret);
        $tokenResponse = $accessTokenRequest->send();

        $accessToken = $tokenResponse['access_token'];
        $refreshToken = $tokenResponse['refresh_token'];

        $refreshTokenRequest = RefreshTokenRequest::getInstance("", $accessToken, $this->clientID, $this->clientSecret, $refreshToken);
        $this->expectException(Exception::class);
        $refreshTokenRequest->send();
    }
}
