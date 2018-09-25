<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class GameController extends AbstractController
{
    /**
     * @Route("/game", name="game")
     */
    public function index()
    {
        $grid = "X---X---X-\nX---X---X-\nX---X---X-\nX--X---X-\nX---X---X-\nX---X---X-\nX---X---X-\nX---X---X-\nX---X---X-\nX---X---X-\nX---X---X-";
        
        return $this->render(
          'game/index.html.twig',
          [
            'grid' => $grid,
          ]
        );
    }
}
