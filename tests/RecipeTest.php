<?php
namespace App;

use App\Entity\Recipe;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;


class RecipeTest extends TestCase {

    private Recipe $recipe;
    
    protected function setUp(): void
    {
        parent::setUp();

        $this->recipe = new Recipe();
    }
    
    public function testGetAll(): void
    {
        $title = "Test 1";
        $subtitle = "Mon sous-titre";
        $list = "Un texte parmis tant d'autre";

        $responseTitle = $this->recipe->setTitle($title);
        $getTitle = $this->recipe->getTitle();

        $responseSubtitle = $this->recipe->setSubtitle($subtitle);
        $getSubtitle = $this->recipe->getSubtitle();

        $responseList = $this->recipe->setList($list);
        $getList = $this->recipe->getList();

        self::assertInstanceOf(Recipe::class, $responseTitle);
        self::assertEquals($title, $getTitle);

        self::assertInstanceOf(Recipe::class, $responseSubtitle);
        self::assertEquals($subtitle, $getSubtitle);

        self::assertInstanceOf(Recipe::class, $responseList);
        self::assertEquals($list, $getList);
    }

}