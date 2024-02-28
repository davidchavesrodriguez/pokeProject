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
    
        // Initialize arrays to store names and sprites
        $pokemonNames = [];
        $pokemonSprites = [];
    
        // Iterate over each Pokemon entity to collect names and sprites
        foreach ($allPokemon as $pokemon) {
            $pokemonNames[] = $pokemon->getName();
            $pokemonSprites[] = $pokemon->getSprite();
        }
    
        // Initialize an array to store HTML elements for each Pokemon
        $pokemonHtml = [];
    
        // Construct HTML elements for each Pokemon
        foreach ($pokemonNames as $index => $name) {
            $sprite = $pokemonSprites[$index];
            $pokemonHtml[] = "<div><strong>$name</strong><br><img src='$sprite' alt='$name'></div>";
        }
    
        // Construct the final HTML response by joining HTML elements
        $htmlResponse = implode('', $pokemonHtml);
    
        // Return a response object with HTML content
        return new Response($htmlResponse);
    }
    


    // Creates the whole database if needed
    // #[Route("/createDatabase", name: "createDatabase")]
    // public function mainpage(): Response{

    //     $entityManager = $this->entityManager; // Use the injected entity manager
    //     $pokemonData = []; // Array para almacenar los datos de los Pokémon

    //     for ($i = 6; $i <= 1025; $i++) { // Loop through the first 10 Pokémon
    //         $url = 'https://pokeapi.co/api/v2/pokemon/' . $i;
    //         $response = file_get_contents($url);
    //         $data = json_decode($response, true);

    //         $pokemon = new Pokemon(); // Create a new Pokemon instance

    //         $pokemon->setName($data['name']);
    //         // Inside your mainpage() method
    //         foreach ($data['types'] as $typeData) {
    //             $typeName[] = $typeData['type']['name']; // Extract the type name from the JSON data
    //             $pokemon->setType($typeName);
    //         }
    //         $typeName= null;

    //         foreach ($data['abilities'] as $abilityData) {
    //             $abilityName[] = $abilityData['ability']['name']; // Extract the ability name from the JSON data
    //             $pokemon->setAbilities($abilityName);
    //         }
    //         $abilityName= null;

    //         foreach ($data['moves'] as $moveData) {
    //             $moveName[] = $moveData['move']['name']; // Extract the move name from the JSON data
    //             $pokemon->setMoves($moveName);
    //         }
    //         $moveName=null;

    //         $pokemon->setSprite($data['sprites']['front_default']);

    //         $entityManager->persist($pokemon); // Persist the Pokemon entity

    //         $pokemonData[] = $pokemon; // Agregar los datos del Pokémon al array principal
    //     }

    //     $entityManager->flush(); // Flush changes to the database

    //     return $this->render("base.html.twig", [
    //         "title" => "PokeProject",
    //         "pokemonData" => $pokemonData,
    //     ]);
    // }
}
