<?php
namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class GamesLibraryController extends AbstractController
{
    /**
     * @Route("/",name="app_home");
     */
    public function home(){
        return $this->render('gamesLibrary/home.html.twig',[

        ]);
    }
}