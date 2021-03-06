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

    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    /**
     * @return array|BookViewModel[]
     */
    public function __invoke(GetAllBooksQuery $query): array
    {
        $viewBooks = [];
        foreach ($this->findBooks($query) as $book) {
            $bookCategory = $book->getCategory();
            $category = new Category($bookCategory->getUuid(), $bookCategory->getName());

            $viewBooks[] = new BookViewModel($book->getUuid(), $book->getName(), $book->getAuthor(), $book->getPrice(),
                $category);
        }

        return $viewBooks;
    }

    /**
     * @return array|Book[]
     */
    protected function findBooks(GetAllBooksQuery $query): array
    {
        // TODO: Add pagination

        if (empty($query->criteria['category'])) {
            return $this->bookRepository->findAll();
        }

        return $this->bookRepository->findByCategoryCriteria($query->criteria);
    }
}
