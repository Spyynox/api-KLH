<?php

namespace App\Tests;

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
            $this->userPayload
        );
        $responseContent = $response->getContent();
        $responseDecoded = json_decode($responseContent);


        $this->assertResponseIsSuccessful();
        static::assertJson($responseContent);
        static::assertNotEmpty($responseDecoded);
    }
}
