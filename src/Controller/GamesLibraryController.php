<?php
namespace App\Controller;


use App\Repository\GamesRepo;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;
use Symfony\Component\Routing\Annotation\Route;

class GamesLibraryController extends AbstractController
{

    /**
     * @Route("/",name="app_home");
     */
    public function home(): \Symfony\Component\HttpFoundation\Response
    {
        $games = GamesRepo::readJsonData();
        $randomGames = GamesRepo::getRandomGames($games,6);

        return $this->render('gamesLibrary/home.html.twig',[
            "games" => $randomGames,
        ]);
    }

    /**
     * @Route("/games/{page}/{order}/{search}",name="app_games");
     */
    public function allGames($page = 1,$order = "asc",$search = null): \Symfony\Component\HttpFoundation\Response
    {
        $games = GamesRepo::readJsonData();
        $sortedGames = GamesRepo::sortGames($games,$order);
        if(!empty($search)){
            $sortedGames = GamesRepo::searchGames($sortedGames,$search);
        }
        $totalGamePages = ceil(count($sortedGames) / 10);
        $filteredGames = GamesRepo::getGamesInPage($sortedGames,$page);

        return $this->render('gamesLibrary/games.html.twig',[
            "games" => $filteredGames,
            "totalGamePages" => $totalGamePages,
            "currentPage" => $page,
            "currentOrderFilter" => $order,
            "currentSearch" => $search
        ]);
    }
}