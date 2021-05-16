<?php


namespace Dotlines\Ghoori;

use Dotlines\Core\Request;

class AccessTokenRequest extends Request
{
    private string $username;
    private string $password;
    private int $clientID;
    private string $clientSecret;

    public static function getInstance(string $url, string $username, string $password, int $clientID, string $clientSecret): AccessTokenRequest
    {
        return new AccessTokenRequest($url, $username, $password, $clientID, $clientSecret);
    }

    private function __construct(string $url, string $username, string $password, int $clientID, string $clientSecret)
    {
        $this->requestMethod = 'POST';
        $this->url = $url;
        $this->username = $username;
        $this->password = $password;
        $this->clientID = $clientID;
        $this->clientSecret = $clientSecret;
    }

    final public function params(): array
    {
        return [
            'grant_type' => 'password',
            'username' => $this->username,
            'password' => $this->password,
            'client_id' => $this->clientID,
            'client_secret' => $this->clientSecret,
            'scope' => '',
        ];
    }
}
