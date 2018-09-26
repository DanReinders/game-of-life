<?php

namespace App\Controller;

use App\Model\Grid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;

class GameController extends AbstractController
{
    /**
     * @Route("/game", name="game")
     */
    public function index(Request $request)
    {
        $form = $this->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $grid = new Grid($data['gridDimension']);
            $grid->addGlider();
        }


        return $this->render(
          'game/index.html.twig',
          [
            'grid' => (isset($grid) ? $grid->toString() : ''),
            'lifecycles' => (isset($data['lifecycles']) ? $data['lifecycles'] : 0),
            'form' => $form->createView(),
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

    private function getForm() {
        return $this->createFormBuilder()
          ->add('gridDimension', TextType::class, array(
            'data' => 25,
            'constraints' => array(
              new NotBlank(),
              new Assert\Range(array(
                'min' => 10,
                'max' => 100,
                'minMessage' => 'Grid size must be {{ limit }} or more.',
                'maxMessage' => 'Grid size must be {{ limit }} or less.',
              ))
            ),
          ))
          ->add('lifecycles', TextType::class, array(
            'data' => 25,
            'constraints' => array(
              new NotBlank(),
              new Assert\Range(array(
                'min' => 10,
                'max' => 500,
                'minMessage' => 'Number of lifecycles must be {{ limit }} or more.',
                'maxMessage' => 'Number of lifecycles must be {{ limit }} or less.',
              ))
            ),
          ))
          ->getForm();
    }
}
