<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PokeController extends AbstractController
{
    #[Route("/", name: "mainpage")]
    public function mainpage(): Response
    {
        dd($_SERVER);
        $pokemonData = []; // Array para almacenar los datos de los Pokémon

        for ($i = 880; $i <= 890; $i++) {
            $url = 'https://pokeapi.co/api/v2/pokemon/' . $i;
            $response = file_get_contents($url);
            $data = json_decode($response, true);

            $pokemon = []; // Array para almacenar los datos de un Pokémon específico

            $pokemon['id'] = $i;
            $pokemon['name'] = $data['name'];

            $types = [];
            if (isset($data["types"])) {
                foreach ($data["types"] as $typeData) {
                    $types[] = $typeData["type"]["name"];
                }
            } else {
                $types[] = "Types not found";
            }

            $abilities = [];
            if (isset($data['abilities'])) {
                foreach ($data['abilities'] as $abilityData) {
                    $abilities[] = $abilityData['ability']['name']; // Añadir la habilidad al array de habilidades
                }
            } else {
                $abilities[] = "Abilities not found";
            }

            $moves = [];
            if (isset($data["moves"])) {
                foreach ($data["moves"] as $moveData) {
                    $moves[] = $moveData["move"]["name"];
                }
            } else {
                $moves[] = "Moves not found";
            }

            $pokemon["types"] = $types;

            $pokemon['abilities'] = $abilities;

            $pokemon["moves"]= $moves;

            $pokemon['sprite'] = $data['sprites']['front_default'];

            $pokemonData[] = $pokemon; // Agregar los datos del Pokémon al array principal
        }

        // Renderizar la plantilla y pasar los datos de los Pokémon
        return $this->render("base.html.twig", [
            "title" => "PokeProject",
            "pokemonData" => $pokemonData,
        ]);
    }
}
