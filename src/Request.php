<?php


namespace Dotlines\Ghoori;

use Dotlines\Ghoori\Helpers\RequestHelper;
use Dotlines\Ghoori\Interfaces\IRequest;
use JsonException;

abstract class Request implements IRequest
{
    protected $requestMethod;
    protected $url;
    protected $accessToken = '';

    abstract public function params(): array;

    final public function headers(): array
    {
        return RequestHelper::make_headers($this->accessToken);
    }

    /**
     * @return array
     * @throws JsonException
     */
    final public function send(): array
    {
        return RequestHelper::send_request($this->requestMethod, $this->url, $this->headers(), $this->params());
    }
}
