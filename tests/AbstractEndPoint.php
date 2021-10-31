<?php

namespace App\Tests;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AbstractEndPoint extends WebTestCase
{
    private array $serverInformations = ['ACCEPT'=>'application/json', 'CONTENT_TYPE' => 'application/json'];

    public function getResponseFromRequest(string $method, string $uri, string $payload = '') : Response
    {
        $client = static::createClient();
        $client->request(
            $method,
            $uri,
            [],
            [],
            $this->serverInformations,
            $payload
        );

        return $client->getResponse();
    }
}
