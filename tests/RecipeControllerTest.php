<?php

namespace App\Tests;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RecipeControllerTest extends WebTestCase
{
    public function testGet(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/api/recipes');

        $this->assertResponseIsSuccessful();
    }

    public function testGetID(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/api/recipes/51');

        $this->assertResponseIsSuccessful();
    }
}
