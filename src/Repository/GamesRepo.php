<?php


namespace App\Repository;


use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;

class GamesRepo
{
    /**
     * This method loads the json file and converts it to json while also removing unnecessary data
     *
     * @return array
     */
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

            !empty($entry["background"])? $filteredEntry["background"] = $entry["background"]: $filteredEntry["background"] = $package->getUrl('/assets/images/no-image.png');

            array_push($filteredData,$filteredEntry);
        }
        return $filteredData;
    }

    /**
     * This method takes the json created by the readJsonData method and returns a number of random
     * games specified by the developer.
     *
     * @param $games
     * @param $count
     * @return array
     */
    public static function getRandomGames($games,$count): array{
        $randomGames = array();

        for($i = 0; $i < $count; $i++){
            array_push($randomGames,$games[rand(0,count($games) - 1)]);
        }

        return $randomGames;
    }

    /**
     * This method takes the json created by the readJsonData method and returns a game using it's id
     *
     * @param $games
     * @param $id
     * @return array|null
     */
    public static function getGameWithId($games,$id): ?array{
        foreach($games as $game) {
            if (strpos(strtolower($game["id"]), strtolower($id)) !== false) {
                return $game;
            }
        }
        return null;
    }

    /**
     * This method takes the json created by the readJsonData method and returns an array of games
     * that contain the search text
     *
     * @param $games
     * @param $search
     * @return array
     */
    public static function searchGames($games,$search): array{
        $filteredGames = array();
        foreach($games as $game) {
            if (strpos(strtolower($game["name"]), strtolower($search)) !== false) {
                array_push($filteredGames,$game);
            }
        }

        return $filteredGames;
    }

    /**
     * This method takes the json created by the readJsonData method and returns an array of orderd games
     * in descending or ascending order
     *
     * @param $games
     * @param $sortType
     * @return array
     */
    public static function sortGames($games, $sortType): array{
        usort($games, function ($a, $b) {
            return strnatcmp($a["name"], $b["name"]);
        });

        if($sortType == "desc")
            $games = array_reverse($games,false);

        return $games;
    }


    /**
     * This method takes the json created by the readJsonData method and returns the games contained
     * in a specified page
     *
     * @param $games
     * @param $pageNumber
     * @return array
     */
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