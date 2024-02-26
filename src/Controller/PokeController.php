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
        for ($i = 490; $i <= 498; $i++) {
            $url = 'https://pokeapi.co/api/v2/pokemon/' . $i;
            $response = file_get_contents($url);
            $data = json_decode($response, true); 

            echo "Pokemon ID: " . $i . "<br>";
            echo "Name: " . $data['name'] . "<br>";
            // $types= $data["types"];
            // foreach ($types as $type) {
            //     $type= $types["type"];
            //     echo "Type: ". $type;
            // }
            if (isset($data['abilities'])) {
                $abilities = $data['abilities'];
                foreach ($abilities as $abilityData) {
                    $ability = $abilityData['ability'];
                    echo "Ability Name: " . $ability['name'] . "<br>";
                }
                echo "<img src='" . $data['sprites']['front_default'] . "'><br>";                echo "<hr>";
            } else {
                echo "Abilities not found for Pokemon ID: " . $i . "<br>";
                echo "<hr>";
            }
        }

        return $this->render("base.html.twig", [
            "title" => "PokeProject"
        ]);
    }
}
