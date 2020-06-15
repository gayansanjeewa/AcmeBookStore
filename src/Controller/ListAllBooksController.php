<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

final class ListAllBooksController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function __invoke()
    {
        return $this->render('home/index.html.twig', [
            'categories' => ['Fiction', 'Children'],
        ]);
    }
}
