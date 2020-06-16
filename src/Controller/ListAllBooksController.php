<?php

namespace App\Controller;

use App\Application\Query\GetAllCategoriesCommand;
use App\Entity\Book;
use App\Entity\Category;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

final class ListAllBooksController extends AbstractController
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @Route("/", name="home")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function __invoke()
    {
        $this->commandBus->handle(new GetAllCategoriesCommand());

        $repository = $this->getDoctrine()->getRepository(Category::class);
        $categories = $repository->findAll();

        $viewCategories = [];
        /** @var Category $category */
        foreach ($categories as $category) {
            $viewCategory = new \App\ViewModel\Category($category->getId(), $category->getName());

            $viewCategories[] = $viewCategory;
        }

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
            'categories' => $viewCategories,
            'books' => $viewBooks,
        ]);
    }
}
