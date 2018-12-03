<?php

namespace spec\Api;

use Api\AuthenticationException;
use Api\Authenticator;
use Domain\InformationProvider;
use Domain\Token;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AuthenticatorSpec extends ObjectBehavior
{
    function let(ClientInterface $client)
    {
        $this->beConstructedWith($client);
    }

    function it_returns_error_when_authentication_fails(ClientInterface $client)
    {
        $informationProvider = InformationProvider::withClientIdAndSecret('clint_id', 'secret');
        $client->request('POST', '/token', [
            'client_id'     => $informationProvider->getClientId(),
            'client_secret' => $informationProvider->getSecret(),
            'grant_type'    => Authenticator::GRANT_TYPE,
        ])->willReturn(new Response(400));
        $this->shouldThrow(new AuthenticationException('Authentication Failed', 400))
            ->during('authenticate', [$informationProvider]);
    }

    function it_returns_true_for_successful_authentication(ClientInterface $client)
    {
        $body = [
            'access_token' => 'access_token',
            'expires_in' => 'expires_in',
            'token_type' => 'token_type',
            'scope' => 'scope'
        ];
        $response = new Response(200, [], json_encode($body));
        $informationProvider = InformationProvider::withClientIdAndSecret('clint_id', 'secret');
        $client->request('POST', '/token', [
            'client_id'     => $informationProvider->getClientId(),
            'client_secret' => $informationProvider->getSecret(),
            'grant_type'    => Authenticator::GRANT_TYPE,
        ])->willReturn($response);

        $this->authenticate($informationProvider)->shouldReturnAnInstanceOf(Token::class);
    }
}
