<?php

/** @noinspection SpellCheckingInspection */
/** @noinspection MethodVisibilityInspection */

namespace Dotlines\Ghoori\Tests;

use Dotlines\Ghoori\AccessTokenRequest;
use GuzzleHttp\Exception\ClientException;
use JsonException;
use PHPUnit\Framework\TestCase;
use Exception;

class AccessTokenRequestTest extends TestCase
{
    public string $tokenUrl = 'https://sb-payments.ghoori.com.bd/oauth/token';
    public string $username = 'someUser@gmail.com';
    public string $password = 'Nopass1234';
    public int $clientID = 27;
    public string $clientSecret = 'HmlIb5kqJnA9N9c79E8WzgZ6Hsoh1d5oyMbNruAw';

    /** @test
     * @throws JsonException
     */
    final public function it_can_fetch_access_token(): void
    {
        $accessTokenRequest = AccessTokenRequest::getInstance($this->tokenUrl, $this->username, $this->password, $this->clientID, $this->clientSecret);
        $tokenResponse = $accessTokenRequest->send();

        self::assertNotEmpty($tokenResponse);
        self::assertArrayHasKey('url', $tokenResponse);
        self::assertArrayHasKey('expires_in', $tokenResponse);
        self::assertArrayHasKey('access_token', $tokenResponse);
        self::assertArrayHasKey('refresh_token', $tokenResponse);
        self::assertNotEmpty($tokenResponse['token_type']);
        self::assertNotEmpty($tokenResponse['expires_in']);
        self::assertNotEmpty($tokenResponse['access_token']);
        self::assertNotEmpty($tokenResponse['refresh_token']);
    }


    /**
     * @test
     */
    final public function it_gets_exception_with_empty_url(): void
    {
        $accessTokenRequest = AccessTokenRequest::getInstance("", $this->username, $this->password, $this->clientID, $this->clientSecret);
        $this->expectException(Exception::class);
        $accessTokenRequest->send();
    }

    /**
     * @test
     */
    final public function it_gets_exception_with_wrong_url(): void
    {
        $accessTokenRequest = AccessTokenRequest::getInstance("https://sb-payments.ghoori.com.bd/oauth", $this->username, $this->password, $this->clientID, $this->clientSecret);
        $this->expectException(ClientException::class);
        $accessTokenRequest->send();
    }

    /**
     * @test
     */
    final public function it_gets_exception_with_empty_username(): void
    {
        $accessTokenRequest = AccessTokenRequest::getInstance($this->tokenUrl, "", $this->password, $this->clientID, $this->clientSecret);
        $this->expectException(ClientException::class);
        $accessTokenRequest->send();
    }

    /**
     * @test
     */
    final public function it_gets_exception_with_wrong_username(): void
    {
        $accessTokenRequest = AccessTokenRequest::getInstance($this->tokenUrl, "wronguser", $this->password, $this->clientID, $this->clientSecret);
        $this->expectException(ClientException::class);
        $accessTokenRequest->send();
    }

    /**
     * @test
     */

    final public function it_gets_exception_with_empty_password(): void
    {
        $accessTokenRequest = AccessTokenRequest::getInstance($this->tokenUrl, $this->username, "", $this->clientID, $this->clientSecret);
        $this->expectException(ClientException::class);
        $accessTokenRequest->send();
    }

    /**
     * @test
     */

    final public function it_gets_exception_with_wrong_password(): void
    {
        $accessTokenRequest = AccessTokenRequest::getInstance($this->tokenUrl, $this->username, "wrongpassword", $this->clientID, $this->clientSecret);
        $this->expectException(ClientException::class);
        $accessTokenRequest->send();
    }

    /**
     * @test
     */

    final public function it_gets_exception_with_empty_client_secret(): void
    {
        $accessTokenRequest = AccessTokenRequest::getInstance($this->tokenUrl, $this->username, $this->password, $this->clientID, "");
        $this->expectException(ClientException::class);
        $accessTokenRequest->send();
    }

    /**
     * @test
     */

    final public function it_gets_exception_with_wrong_client_secret(): void
    {
        $accessTokenRequest = AccessTokenRequest::getInstance($this->tokenUrl, $this->username, $this->password, $this->clientID, "wrongclientsecret");
        $this->expectException(ClientException::class);
        $accessTokenRequest->send();
    }


    /**
     * @test
     */
    final public function it_gets_exception_with_negative_client_id(): void
    {
        $accessTokenRequest = AccessTokenRequest::getInstance($this->tokenUrl, $this->username, $this->password, -27, $this->clientSecret);
        $this->expectException(ClientException::class);
        $accessTokenRequest->send();
    }

    /**
     * @test
     */
    final public function it_gets_exception_with_wrong_client_id(): void
    {
        $accessTokenRequest = AccessTokenRequest::getInstance($this->tokenUrl, $this->username, $this->password, 29, $this->clientSecret);
        $this->expectException(ClientException::class);
        $accessTokenRequest->send();
    }
}
