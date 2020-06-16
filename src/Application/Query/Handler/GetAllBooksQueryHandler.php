<?php

namespace App\Application\Query\Handler;

use App\Application\BusHandlerInterface;
use App\Application\Contract\BookRepositoryInterface;
use App\Application\Query\GetAllBooksQuery;
use App\Entity\Book;
use App\ViewModel\Book as BookViewModel;
use App\ViewModel\Category;

final class GetAllBooksQueryHandler implements BusHandlerInterface
{
    /**
     * @var BookRepositoryInterface
     */
    private $bookRepository;

    /**
     * @param BookRepositoryInterface $bookRepository
     */
    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    /**
     * @param GetAllBooksQuery $query
     *
     * @return array|BookViewModel[]
     */
    public function __invoke(GetAllBooksQuery $query): array
    {
        /** @var Book[] $books */
        $books = $this->bookRepository->findAll();

        $viewBooks = [];
        foreach ($books as $book) {
            $bookCategory = $book->getCategory();
            $category = new Category($bookCategory->getUuid(), $bookCategory->getName());

            $viewBooks[] = new BookViewModel($book->getUuid(), $book->getName(), $book->getAuthor(), $book->getPrice(), $category);
        }

        return $viewBooks;
    }
}
