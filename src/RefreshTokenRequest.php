<?php


namespace Dotlines\Ghoori;

use Dotlines\Core\Request;

class RefreshTokenRequest extends Request
{
    private int $clientID;
    private string $clientSecret;
    private string $refreshToken;

    public static function getInstance(string $url, string $accessToken, int $clientID, string $clientSecret, string $refreshToken): RefreshTokenRequest
    {
        return new RefreshTokenRequest($url, $accessToken, $clientID, $clientSecret, $refreshToken);
    }

    private function __construct(string $url, string $accessToken, int $clientID, string $clientSecret, string $refreshToken)
    {
        $this->requestMethod = 'POST';
        $this->url = $url;
        $this->accessToken = $accessToken;

        $this->clientID = $clientID;
        $this->clientSecret = $clientSecret;
        $this->refreshToken = $refreshToken;
    }

    final public function params(): array
    {
        return [
            'grant_type' => 'refresh_token',
            'client_id' => $this->clientID,
            'client_secret' => $this->clientSecret,
            'refresh_token' => $this->refreshToken,
            'scope' => '',
        ];
    }
}
