<?php

namespace spec\Domain;

use Domain\Token;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TokenSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWithDetails(
            [
                'access_token' => 'random',
                'expires_in' => 99999999999,
                'token_type' => 'Bearer',
                'scope' => 'TheForce'
            ]
        );
    }

    function it_exposes_details()
    {
        $this->getDetails()->shouldReturn(
            [
                'access_token' => 'random',
                'expires_in' => 99999999999,
                'token_type' => 'Bearer',
                'scope' => 'TheForce'
            ]
        );
    }
}
