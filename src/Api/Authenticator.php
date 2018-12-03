<?php

namespace Api;

use Domain\InformationProvider;
use Domain\Token;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

class Authenticator
{

    const GRANT_TYPE = 'client_credentials';

    /**
     * @var ClientInterface
     */
    private $client;

    function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function authenticate(InformationProvider $informationProvider): Token
    {
        $request = $this->client->request('POST', '/token', [
            'client_id'     => $informationProvider->getClientId(),
            'client_secret' => $informationProvider->getSecret(),
            'grant_type'    => static::GRANT_TYPE,
        ])->withAddedHeader('Content-Type', 'application/x-www-form-urlencoded');

        if ($request->getStatusCode() === 200) {
            $data = json_decode($request->getBody(), true);

            return Token::withDetails($data);
        }

        throw new AuthenticationException(
            'Authentication Failed' . $request->getBody()->getContents(),
            $request->getStatusCode()
        );
    }
}
