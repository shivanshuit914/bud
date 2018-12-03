<?php

namespace Domain;

class Token
{

    /**
     * @var string
     */
    private $accessToken;
    /**
     * @var int
     */
    private $expiresIn;
    /**
     * @var string
     */
    private $tokenType;
    /**
     * @var string
     */
    private $scope;

    private function __construct(string $accessToken, int $expiresIn, string $tokenType, string $scope)
    {
        $this->accessToken = $accessToken;
        $this->expiresIn = $expiresIn;
        $this->tokenType = $tokenType;
        $this->scope = $scope;
    }

    public static function withDetails(array $details)
    {
        return new static(
            $details['access_token'],
            (int) $details['expires_in'],
            $details['token_type'],
            $details['scope']
        );
    }

    public function getDetails(): array
    {
        return [
            'access_token' => $this->accessToken,
            'expires_in' => $this->expiresIn,
            'token_type' => $this->tokenType,
            'scope' => $this->scope
        ];
    }

    public function getAccessToken(): string
    {
        return $this->accessToken;
    }
}
