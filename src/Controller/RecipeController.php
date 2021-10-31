<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Repository\RecipeRepository;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RecipeController extends AbstractController
{
    /**
     * @Route("/api/recipes", name="recipeGetAll", methods={"GET"})
     */
    public function GetAll(RecipeRepository $recipesRepo): Response
    {
        $recipes = $recipesRepo->apiFindAll();

        $encoders = [new JsonEncoder()];

        // We instantiate the "normalizer" to convert the collection into an array
        $normalizers = [new ObjectNormalizer()];

        // We instantiate the converter
        $serializer = new Serializer($normalizers, $encoders);

        // We convert to json
        $jsonContent = $serializer->serialize($recipes, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);

        // We instantiate the response
        $response = new Response($jsonContent);

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/api/recipes/{id}", name="recipeGetID", methods={"GET"})
     * @Entity("recipe", expr="repository.find(id)")
     */
    public function GetID(Recipe $recipe): Response
    {
        // We specify that we use the JSON encoder
        $encoders = [new JsonEncoder()];

        // We instantiate the "normalizer" to convert the collection into an array
        $normalizers = [new ObjectNormalizer()];

        // We instantiate the converter
        $serializer = new Serializer($normalizers, $encoders);

        // We convert to json
        $jsonContent = $serializer->serialize($recipe, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);

        $response = new Response($jsonContent);

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/api/recipes", name="recipePost", methods={"POST"})
     */
    public function Post(Request $request): Response
    {
            $recipe = new Recipe();

            // We decode the data sent
            $data = json_decode($request->getContent());

            $recipe->setTitle($data->title);
            $recipe->setSubtitle($data->subtitle);
            $recipe->setList($data->list);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($recipe);
            $entityManager->flush();

            return new Response('Le POST a marché !', 201);
    }

    /**
     * @Route("/api/recipes/{id}", name="recipePut", methods={"PUT"})
     */
    public function Put(Recipe $recipe, Request $request): Response
    {
        $data = json_decode($request->getContent());
        
        $recipe->setTitle($data->title);
        $recipe->setSubtitle($data->subtitle);
        $recipe->setList($data->list);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($recipe);
        $entityManager->flush();

        return new Response('ok', 200);
    }

    /**
     * @Route("/api/recipes/{id}", name="recipeDelete", methods={"DELETE"})
     */
    public function Delete(Recipe $recipe): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($recipe);
        $entityManager->flush();
        return new Response('Supression réussi', 200);
    }
}
