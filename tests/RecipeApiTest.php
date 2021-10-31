<?php

namespace App\Tests;

use Faker\Factory;
use App\Tests\AbstractEndPoint;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RecipeApiTest extends AbstractEndPoint
{
    private string $userPayload = '{"title": "%s", "subtitle": "test", "list": "text"}';

    public function testApiRecipeGet(): void
    {
        $response = $this->getResponseFromRequest(Request::METHOD_GET, '/api/recipes');
        $responseContent = $response->getContent();
        $responseDecoded = json_decode($responseContent);

        $this->assertResponseIsSuccessful();
        static::assertJson($responseContent);
        static::assertNotEmpty($responseDecoded);
    }
    
    public function testApiRecipePost(): void
    {
        $response = $this->getResponseFromRequest(Request::METHOD_POST, '/api/recipes',
            $this->getPayload()
        );
        $responseContent = $response->getContent();
        $responseDecoded = json_decode($responseContent);

        dd($responseContent);

        $this->assertResponseIsSuccessful();
        static::assertJson($responseContent);
        static::assertNotEmpty($responseDecoded);
    }

    private function getPayload(): string
    {
        $faker = Factory::create();

        return sprintf($this->userPayload, $faker->name);
    }
}
