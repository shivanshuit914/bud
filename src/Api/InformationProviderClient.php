<?php
/**
 * Created by IntelliJ IDEA.
 * User: shivanshu
 * Date: 03/12/2018
 * Time: 12:20
 */

namespace Api;

use Domain\Prisoner;
use Domain\Token;
use Exception;
use GuzzleHttp\ClientInterface;

class InformationProviderClient implements ThirdPartyClient
{

    /**
     * @var Token
     */
    private $token;
    /**
     * @var ClientInterface
     */
    private $client;

    public function __construct(Token $token, ClientInterface $client)
    {
        $this->token = $token;
        $this->client = $client;
    }

    public function get(string $name): Prisoner
    {
        $headers = [
            'Authorization' => 'Bearer ' . $this->token->getAccessToken(),
            'Accept'        => 'application/json',
        ];
        $response = $this->client->request('GET', '/prisoner/'.$name, ['headers' => $headers]);
        $data = json_decode($response->getBody(), true);

        if (empty($data)) {
            throw new Exception('Prisoner with name ' . $name . ' does not exits');
        }

        return Prisoner::withNameAndAddress(
            $name,
            [
                'block' => $data['block'],
                'cell' => $data['cell']
            ]
        );
    }

    public function delete(int $id)
    {
        $headers = [
            'Authorization' => 'Bearer ' . $this->token->getAccessToken(),
            'Accept' => 'application/json',
            'x-torpedoes' =>2
        ];
        $this->client->request('DELETE', '/reactor/exhaust/'.$id, ['headers' => $headers]);
    }
}