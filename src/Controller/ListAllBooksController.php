<?php

namespace App\Controller;

use App\Application\Query\GetAllBooksQuery;
use App\Application\Query\GetAllCategoriesQuery;
use App\ViewModel\Book;
use App\ViewModel\Category;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

final class ListAllBooksController extends AbstractController
{
    /**
     * @var CommandBus
     */
    private $bus;

    public function __construct(CommandBus $bus)
    {
        $this->bus = $bus;
    }

    /**
     * @Route("/", name="home")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function __invoke()
    {
        /** @var Category[] $categories */
        $categories = $this->bus->handle(new GetAllCategoriesQuery());

        /** @var Book $books */
        $books = $this->bus->handle(new GetAllBooksQuery());

        return $this->render('home/index.html.twig', [
            'categories' => $categories,
            'books'      => $books,
        ]);
    }
}
