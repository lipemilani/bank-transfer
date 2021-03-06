<?php

namespace App\Infrastructure\Integrations;

use \Httpful\Request as Request;

/**
 * Class AuthorizationService
 * @package App\Infrastructure\Integrations
 */
class AuthorizationService
{
    /**
     * @var string
     */
    protected string $protocol;

    /**
     * @var string
     */
    protected string $apiUrl;

    /**
     * @var string
     */
    protected string $apiEndPoint;

    /**
     * AuthorizationService constructor.
     */
    public function __construct()
    {
        $this->protocol = 'https';
        $this->apiUrl = 'run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6';

        $this->apiEndPoint = $this->protocol . '://' . $this->apiUrl;
    }

    /**
     * @return bool
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function send(): bool
    {
        $result = Request::get($this->apiEndPoint)->send();

        if ($result->code !== 200) {
            return false;
        }

        return true;
    }
}
