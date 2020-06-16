<?php

namespace App\Controller;

use App\Application\Query\GetAllCategoriesQuery;
use App\Entity\Book;
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
        /** @var \App\ViewModel\Category[] $categories */
        $categories = $this->bus->handle(new GetAllCategoriesQuery());

        $repository = $this->getDoctrine()->getRepository(Book::class);
        $books = $repository->findAll();

        $viewBooks = [];
        /** @var Book $book */
        foreach ($books as $book) {
            $bookCategory = $book->getCategory();
            $category = new \App\ViewModel\Category($bookCategory->getId(), $bookCategory->getName());

            $viewBooks[] = new \App\ViewModel\Book($book->getId(), $book->getName(), $book->getAuthor(), $book->getPrice(), $category);
        }

        return $this->render('home/index.html.twig', [
            'categories' => $categories,
            'books' => $viewBooks,
        ]);
    }
}
