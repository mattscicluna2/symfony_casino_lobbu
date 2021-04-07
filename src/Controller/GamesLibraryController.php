<?php
namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;
use Symfony\Component\Routing\Annotation\Route;

class GamesLibraryController extends AbstractController
{
    /**
     * @Route("/{page}",name="app_home");
     */
    public function home($page = 1,$order = "asc"): \Symfony\Component\HttpFoundation\Response
    {
        $games = $this->readJsonData();
        $totalGamePages = ceil(count($games) / 10);

        $filteredGames = $this->getGamesInPage($games,$page);

        return $this->render('gamesLibrary/home.html.twig',[
            "games" => $filteredGames,
            "totalGamePages" => $totalGamePages,
        ]);
    }

    private function getGamesInPage($games, $pageNumber): array{
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

    private function readJsonData(): array{
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

            !empty($entry["background"])? $filteredEntry["background"] = $entry["background"]: $filteredEntry["background"] = $package->getUrl('assets/images/inner-hero.jpg');

            array_push($filteredData,$filteredEntry);
        }
        return $filteredData;
    }

}