<?php

namespace App\Controller;

use App\Model\Grid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class GameController extends AbstractController
{
    /**
     * @Route("/game", name="game")
     */
    public function index()
    {
        $grid = new Grid(50);
        $grid->addGlider();

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
    public function updateGrid(Request $request)
    {
        $params = json_decode($request->getContent(), true);

        $grid = new Grid();

        $grid->setGridFromString($params['grid']);
        $grid->executeLifeCycle();

        return new JsonResponse(['grid' => $grid->toString()]);
    }
}
