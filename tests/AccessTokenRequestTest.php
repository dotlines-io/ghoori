<?php

/** @noinspection MethodVisibilityInspection */

namespace Dotlines\Ghoori\Tests;

use Dotlines\Ghoori\AccessTokenRequest;
use JsonException;
use PHPUnit\Framework\TestCase;

class AccessTokenRequestTest extends TestCase
{
    /** @test
     * @throws JsonException
     */
    final public function it_can_fetch_access_token(): void
    {
        $tokenUrl = getenv('SERVER_URL') . '/oauth/token';
        $username = getenv('USERNAME');
        $password = getenv('PASSWORD');
        $clientID = (int)getenv('CLIENT_ID');
        $clientSecret = getenv('CLIENT_SECRET');
        $accessTokenRequest = AccessTokenRequest::getInstance($tokenUrl, $username, $password, $clientID, $clientSecret);

        $tokenResponse = $accessTokenRequest->send();

        self::assertNotEmpty($tokenResponse);
    }
}
