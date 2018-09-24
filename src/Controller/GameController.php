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
        $imagesPath = $this->getParameter('images_directory');

        $mask = $imagesPath.'/gol*.*';
        array_map('unlink', glob($mask));

        // Create a blank image and add some text
        $image = imagecreatetruecolor(300, 300);
        $textColor = imagecolorallocate($image, 255, 255, 255);
        imagestring($image, 1, 50, 50, 'A Simple Text String', $textColor);

        $imageName = '/gol'.time().'.png';
        imagepng($image, $imagesPath.$imageName);

        // Free up memory
        imagedestroy($image);

        return $this->render(
          'game/index.html.twig',
          [
            'controller_name' => 'GameController',
            'image_name' => 'images/'.$imageName,
          ]
        );
    }
}
