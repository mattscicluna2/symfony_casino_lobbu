<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{

    public function homepage(){
        return new Response("Homepage");
    }


    public function show($slug){
        $answers = [
            'Make sure your cat is sitting purrrfectly still 🤣',
            'Honestly, I like furry shoes better than MY cat',
            'Maybe... try saying the spell backwards?',
        ];

        dump($slug,$this);

        return $this->render('question/show.html.twig',[
            'question' => 'testing123',
            'answers' => $answers
        ]);
    }
}