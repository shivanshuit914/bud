<?php

use Api\Authenticator;
use Api\InformationProviderClient;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Domain\InformationProvider;
use Domain\PrisonerFinder;
use Domain\Token;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Library\DroidSpeakTranslator;
use PHPUnit\Framework\Assert;

/**
 * Defines application features from the specific context.
 */
class ApiConsumptionContext implements Context
{

    private $provider;

    private $authenticator;

    private $token;

    private $authenticatedClient;

    /**
     * @var PrisonerFinder
     */
    private $informationFinder;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $body = [
            'access_token' => 'access_token',
            'expires_in' => 'expires_in',
            'token_type' => 'token_type',
            'scope' => 'scope'
        ];
        $mock = new MockHandler([
            new Response(200, [], json_encode($body))
        ]);
        $handler = HandlerStack::create($mock);
        $envVariables = new Dotenv\Dotenv(__DIR__ . '/../../');
        $envVariables->load();
        $this->authenticator = new Authenticator(new Client(['handler' => $handler]));
    }



    /**
     * @Given There is a third party which provides information to authenticated client
     */
    public function thereIsAThirdPartyWhichProvidesInformationToAuthenticatedClient()
    {
        $this->provider = InformationProvider::withClientIdAndSecret(
            getenv('CLIENT_ID'),
            getenv('CLIENT_SECRET')
        );
    }



    /**
     * @When I authenticate client
     */
    public function iAuthenticateClient()
    {
        $this->token = $this->authenticator->authenticate($this->provider);
    }

    /**
     * @Then I should receive token
     */
    public function iShouldReceiveToken()
    {
        Assert::assertInstanceOf(Token::class, $this->token);
    }

    /**
     * @Given Successful authenticated client
     */
    public function successfulAuthenticatedClient()
    {
        $this->authenticatedClient = Token::withDetails(
            [
                'access_token' => 'access_token',
                'expires_in' => 'expires_in',
                'token_type' => 'token_type',
                'scope' => 'scope'
            ]
        );
    }

    /**
     * @When I try to retrieve information
     */
    public function iTryToRetrieveInformation()
    {
        $body = [
            'cell' => '01000100 01100101 01110100 01100101 01101110',
            'block' => '01000011 01100101 01101100 01101100'
        ];
        $mock = new MockHandler([
            new Response(200, [], json_encode($body))
        ]);
        $handler = HandlerStack::create($mock);
        $this->informationFinder = new PrisonerFinder(
            new InformationProviderClient(
                $this->authenticatedClient,
                new Client(['handler' => $handler])
            ),
            new DroidSpeakTranslator());
    }

    /**
     * @Then I should receive details
     */
    public function iShouldReceiveDetails()
    {
        $info = $this->informationFinder->find('leia');
        Assert::assertEquals('DetenCell', $info);
    }
}
