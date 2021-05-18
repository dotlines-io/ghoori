<?php

/** @noinspection SpellCheckingInspection */
/** @noinspection MethodVisibilityInspection */

namespace Dotlines\Ghoori\Tests;

use Dotlines\Ghoori\AccessTokenRequest;
use JsonException;
use PHPUnit\Framework\TestCase;

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
        self::assertArrayHasKey('token_type', $tokenResponse);
        self::assertArrayHasKey('expires_in', $tokenResponse);
        self::assertArrayHasKey('access_token', $tokenResponse);
        self::assertArrayHasKey('refresh_token', $tokenResponse);
    }
}
