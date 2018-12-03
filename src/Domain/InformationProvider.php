<?php

namespace Domain;

class InformationProvider
{

    /**
     * @var string
     */
    private $clientId;
    /**
     * @var string
     */
    private $secret;

    private function __construct(string $clientId, string $secret)
    {
        $this->clientId = $clientId;
        $this->secret = $secret;
    }

    public static function withClientIdAndSecret(string $clientId, string $secret): InformationProvider
    {
        return new static($clientId, $secret);
    }

    public function getClientId(): string
    {
        return $this->clientId;
    }

    public function getSecret(): string
    {
        return $this->secret;
    }
}
