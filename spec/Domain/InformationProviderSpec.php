<?php

namespace spec\Domain;

use Domain\InformationProvider;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class InformationProviderSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWithClientIdAndSecret('client_id', 'secret');
    }

    function it_exposes_client_id()
    {
        $this->getClientId()->shouldReturn('client_id');
    }

    function it_exposes_secret()
    {
        $this->getSecret()->shouldReturn('secret');
    }
}
