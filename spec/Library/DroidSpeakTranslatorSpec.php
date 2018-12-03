<?php

namespace spec\Library;

use Domain\DroidSpeakTranslator;
use Exception;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DroidSpeakTranslatorSpec extends ObjectBehavior
{
    function it_translates_to_english_from_binary()
    {
        $this->translate('01000011 01100101 01101100 01101100')->shouldReturn('Cell');
    }

    function it_return_error_for_non_binary_information()
    {
        $this->shouldThrow(new Exception('Binary is not valid'))->duringTranslate('010000112');
    }
}
