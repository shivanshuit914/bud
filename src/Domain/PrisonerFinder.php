<?php

namespace Domain;

use Api\ThirdPartyClient;
use Exception;
use Library\Translator;

class PrisonerFinder
{

    /**
     * @var ThirdPartyClient
     */
    private $client;

    /**
     * @var Translator
     */
    private $translator;

    public function __construct(ThirdPartyClient $client, Translator $translator)
    {
        $this->client = $client;
        $this->translator = $translator;
    }

    public function find(string $name): string
    {
        try {
            $prisoner = $this->client->get($name);
            $address = $prisoner->getAddress();
            $block = $this->translator->translate($address['block']);
            $cell = $this->translator->translate($address['cell']);

            return $cell.$block;
        } catch (Exception $exception) {
            // Log error or handler depending on feature.
            return '';
        }
    }
}
