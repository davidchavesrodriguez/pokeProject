<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Pokemon; // Import the Pokemon entity
use App\Repository\PokemonRepository;
use Doctrine\ORM\EntityManagerInterface;

class PokeController extends AbstractController
{
    private $entityManager;
    private $pokemonRepository;

    public function __construct(EntityManagerInterface $entityManager, PokemonRepository $pokemonRepository)
    {
        $this->entityManager = $entityManager;
        $this->pokemonRepository = $pokemonRepository;
    }

    #[Route("/", name: "mainpage")]
    public function getNamesAndSprites()
    {
        // Call the findAll method to retrieve all Pokemon entities
        $allPokemon = $this->pokemonRepository->findAll();

        // Return a response object with HTML content
        return $this->render("base.html.twig", [
            "title" => "PokeProject",
            "pokemonData" => $allPokemon,
        ]);
    }

    #[Route("/{id}", name: "showInfo", methods: ["GET"])]
    public function showInfo(int $id): Response
    {
        $pokemon = $this->pokemonRepository->find($id);
        if (!$pokemon) {
            throw $this->createNotFoundException('Park not found');
        }
$moves = $pokemon->getMoves();

if (count($moves) >= 4) {
    $randomMoves = array_rand($moves, 4);
} else {
    $randomMoves = array_keys($moves);
}
$selectedMoves = [];
foreach ($randomMoves as $index) {
    $selectedMoves[] = $moves[$index];
}
        return $this->render("/showInfo.html.twig", [
            "title" => $pokemon->getName(),
            "pokemon" => $pokemon,
            'selectedMoves' => $selectedMoves,

        ]);
    }


    // Creates the whole database if needed
    #[Route("/createDatabase", name: "createDatabase")]
    public function createDatabase(): Response
    {

        $entityManager = $this->entityManager; // Use the injected entity manager
        $pokemonData = []; // Array para almacenar los datos de los Pokémon

        for ($i = 1; $i <= 1025; $i++) { // Loop through the first 10 Pokémon
            $url = 'https://pokeapi.co/api/v2/pokemon/' . $i;
            $response = file_get_contents($url);
            $data = json_decode($response, true);

            $pokemon = new Pokemon(); // Create a new Pokemon instance

            $pokemon->setName($data['name']);
            foreach ($data['types'] as $typeData) {
                $typeName[] = $typeData['type']['name']; // Extract the type name from the JSON data
                $pokemon->setType($typeName);
            }
            $typeName = null;

            foreach ($data['abilities'] as $abilityData) {
                $abilityName[] = $abilityData['ability']['name']; // Extract the ability name from the JSON data
                $pokemon->setAbilities($abilityName);
            }
            $abilityName = null;

            foreach ($data['moves'] as $moveData) {
                $moveName[] = $moveData['move']['name']; // Extract the move name from the JSON data
                $pokemon->setMoves($moveName);
            }
            $moveName = null;

            $pokemon->setSprite($data['sprites']['front_default']);

            $entityManager->persist($pokemon); // Persist the Pokemon entity

            $pokemonData[] = $pokemon;
        }

        $entityManager->flush(); // Flush changes to the database

        return $this->render("base.html.twig", [
            "title" => "PokeProject",
            "pokemonData" => $pokemonData,
        ]);
    }
}
