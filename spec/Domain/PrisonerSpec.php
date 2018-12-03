<?php

namespace spec\Domain;

use Domain\Prisoner;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PrisonerSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWithNameAndAddress('leia', ['cell' => '"01000011', 'block' => '"01000011']);
    }

    function it_exposes_address()
    {
        $this->getAddress()->shouldReturn(['cell' => '"01000011', 'block' => '"01000011']);
    }
}
