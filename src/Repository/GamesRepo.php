<?php


namespace App\Repository;


use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;

class GamesRepo
{
    public static function readJsonData(): array{
        $package = new Package(new EmptyVersionStrategy());
        $path = $package->getUrl('data.json');
        $data = file_get_contents($path);
        $jsonData = json_decode($data,1);
        $filteredData = array();

        foreach($jsonData as $entry){
            $filteredEntry = [
                "id" => $entry["id"],
                "name" => $entry["name"],
                "icon" => $entry["icon_2"]
            ];

            !empty($entry["background"])? $filteredEntry["background"] = $entry["background"]: $filteredEntry["background"] = $package->getUrl('/assets/images/inner-hero.jpg');

            array_push($filteredData,$filteredEntry);
        }
        return $filteredData;
    }

    public static function getRandomGames($games,$count): array{
        $randomGames = array();

        for($i = 0; $i < $count; $i++){
            array_push($randomGames,$games[rand(0,count($games) - 1)]);
        }

        return $randomGames;
    }

    public static function searchGames($games,$search): array{
        $filteredGames = array();
        foreach($games as $game) {
            if (strpos(strtolower($game["name"]), strtolower($search)) !== false) {
                array_push($filteredGames,$game);
            }
        }

        return $filteredGames;
    }

    public static function sortGames($games, $sortType): array{
        usort($games, function ($a, $b) {
            return strnatcmp($a["name"], $b["name"]);
        });

        if($sortType == "desc")
            $games = array_reverse($games,false);

        return $games;
    }


    public static function getGamesInPage($games, $pageNumber): array{
        $filteredGames = array();
        $startPos = ($pageNumber - 1) * 10;

        for($i = 0; $i < 10; $i++){
            if(empty($games[$startPos + $i]))
                break;

            $entry = $games[$startPos + $i];
            array_push($filteredGames,$entry);
        }

        return $filteredGames;
    }
}