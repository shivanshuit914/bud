<?php

namespace spec\Domain;

use Domain\Prisoner;
use Domain\PrisonerFinder;
use Library\Translator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Api\ThirdPartyClient;

class PrisonerFinderSpec extends ObjectBehavior
{
    function let(ThirdPartyClient $thirdPartyClient, Translator $translator)
    {
        $this->beConstructedWith($thirdPartyClient, $translator);
    }

    function it_returns_prisoner_address_in_english_when_it_finds(ThirdPartyClient $thirdPartyClient, Translator $translator)
    {
        $translator->translate('01000100 01100101 01110100 01100101 01101110')->willReturn('Cell');
        $translator->translate('01000011 01100101 01101100 01101100')->willReturn('Bloc');
        $thirdPartyClient->get('leia')->willReturn(Prisoner::withNameAndAddress('leia',
            [
                'block' => '01000100 01100101 01110100 01100101 01101110',
                'cell' => '01000011 01100101 01101100 01101100',
            ]));
        $this->find('leia')->shouldReturn('BlocCell');
    }
}
