<?php

namespace App\Controller;

use App\Model\Grid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class GameController extends AbstractController
{
    /**
     * @Route("/game", name="game")
     */
    public function index()
    {
        $grid = new Grid(10);

        return $this->render(
          'game/index.html.twig',
          [
            'grid' => $grid->toString(),
          ]
        );
    }

    /**
     * @Route("/game/update-grid", name="update-grid")
     */
    public function updateGrid()
    {
        $grid = new Grid();

//        $grid->setGrid([]);
        $grid->addGlider();
        $grid->executeLifeCycle();

        return new JsonResponse(['grid' => $grid->toString()]);
    }
}
