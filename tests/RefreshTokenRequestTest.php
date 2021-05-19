<?php

/** @noinspection SpellCheckingInspection */

/** @noinspection MethodVisibilityInspection */

namespace Dotlines\Ghoori\Tests;

use Dotlines\Ghoori\AccessTokenRequest;
use Dotlines\Ghoori\RefreshTokenRequest;
use Exception;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use JsonException;
use PHPUnit\Framework\TestCase;

class RefreshTokenRequestTest extends TestCase
{
    public string $tokenUrl = 'https://sb-payments.ghoori.com.bd/oauth/token';
    public string $username = 'someUser@gmail.com';
    public string $password = 'Nopass1234';
    public int $clientID = 27;
    public string $clientSecret = 'HmlIb5kqJnA9N9c79E8WzgZ6Hsoh1d5oyMbNruAw';
    public string $accessToken = "";
    public string $refreshToken = "";

    /**
     * @throws JsonException
     */
    public function setUp(): void
    {
        parent::setUp();
        $accessTokenRequest = AccessTokenRequest::getInstance($this->tokenUrl, $this->username, $this->password, $this->clientID, $this->clientSecret);
        $tokenResponse = $accessTokenRequest->send();

        $this->accessToken = $tokenResponse['access_token'];
        $this->refreshToken = $tokenResponse['refresh_token'];
    }

    /** @test
     * @throws JsonException
     */
    final public function it_can_refresh_access_token(): void
    {
        $refreshTokenRequest = RefreshTokenRequest::getInstance($this->tokenUrl, $this->accessToken, $this->clientID, $this->clientSecret, $this->refreshToken);
        $refreshTokenResponse = $refreshTokenRequest->send();

        self::assertNotEmpty($refreshTokenResponse);
        self::assertArrayHasKey('token_type', $refreshTokenResponse);
        self::assertArrayHasKey('expires_in', $refreshTokenResponse);
        self::assertArrayHasKey('access_token', $refreshTokenResponse);
        self::assertArrayHasKey('refresh_token', $refreshTokenResponse);
    }

    /**
     * Testing $tokenUrl param
     */

    /**
     * @test
     * @throws JsonException
     */
    final public function it_gets_exception_with_empty_tokenUrl(): void
    {
        $this->tokenUrl = "";
        $refreshTokenRequest = RefreshTokenRequest::getInstance($this->tokenUrl, $this->accessToken, $this->clientID, $this->clientSecret, $this->refreshToken);
        $this->expectException(Exception::class);
        $refreshTokenRequest->send();
    }

    /**
     * @test
     * @throws JsonException
     */
    final public function it_gets_exception_with_wrong_tokenUrl(): void
    {
        $this->tokenUrl = "sdasdadssad";
        $refreshTokenRequest = RefreshTokenRequest::getInstance($this->tokenUrl, $this->accessToken, $this->clientID, $this->clientSecret, $this->refreshToken);
        $this->expectException(ConnectException::class);
        $refreshTokenRequest->send();
    }

    /**
     * Testing $clientID param
     */

    /**
     * @test
     * @throws JsonException
     */
    final public function it_gets_exception_with_clientID_zero(): void
    {
        $this->clientID = 0;
        $refreshTokenRequest = RefreshTokenRequest::getInstance($this->tokenUrl, $this->accessToken, $this->clientID, $this->clientSecret, $this->refreshToken);
        $this->expectException(Exception::class);
        $refreshTokenRequest->send();
    }

    /**
     * @test
     * @throws JsonException
     */
    final public function it_gets_exception_with_negative_clientID(): void
    {
        $this->clientID = -27;
        $refreshTokenRequest = RefreshTokenRequest::getInstance($this->tokenUrl, $this->accessToken, $this->clientID, $this->clientSecret, $this->refreshToken);
        $this->expectException(ClientException::class);
        $refreshTokenRequest->send();
    }

    /**
     * @test
     * @throws JsonException
     */
    final public function it_gets_exception_with_wrong_clientID(): void
    {
        $this->clientID = 9999999999;
        $refreshTokenRequest = RefreshTokenRequest::getInstance($this->tokenUrl, $this->accessToken, $this->clientID, $this->clientSecret, $this->refreshToken);
        $this->expectException(ClientException::class);
        $refreshTokenRequest->send();
    }

    /**
     * @test
     * @throws JsonException
     */
    final public function it_gets_exception_with_large_clientID(): void
    {
        $this->clientID = 99999999999;
        $refreshTokenRequest = RefreshTokenRequest::getInstance($this->tokenUrl, $this->accessToken, $this->clientID, $this->clientSecret, $this->refreshToken);
        $this->expectException(ClientException::class);
        $refreshTokenRequest->send();
    }

    /**
     * Testing $clientSecret param
     */

    /**
     * @test
     * @throws JsonException
     */
    final public function it_gets_exception_with_empty_clientSecret(): void
    {
        $this->clientSecret = "";
        $refreshTokenRequest = RefreshTokenRequest::getInstance($this->tokenUrl, $this->accessToken, $this->clientID, $this->clientSecret, $this->refreshToken);
        $this->expectException(ClientException::class);
        $refreshTokenRequest->send();
    }

    /**
     * @test
     * @throws JsonException
     */
    final public function it_gets_exception_with_integer_clientSecret(): void
    {
        $this->clientSecret = 22;
        $refreshTokenRequest = RefreshTokenRequest::getInstance($this->tokenUrl, $this->accessToken, $this->clientID, $this->clientSecret, $this->refreshToken);
        $this->expectException(ClientException::class);
        $refreshTokenRequest->send();
    }

    /**
     * @test
     * @throws JsonException
     */
    final public function it_gets_exception_with_wrong_clientSecret(): void
    {
        $this->clientSecret = "sssssssssssssssssssssssssssssssssssssssss";
        $refreshTokenRequest = RefreshTokenRequest::getInstance($this->tokenUrl, $this->accessToken, $this->clientID, $this->clientSecret, $this->refreshToken);
        $this->expectException(ClientException::class);
        $refreshTokenRequest->send();
    }
}
