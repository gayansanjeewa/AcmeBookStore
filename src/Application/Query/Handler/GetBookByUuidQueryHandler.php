<?php

namespace App\Application\Query\Handler;

use App\Application\BusHandlerInterface;
use App\Application\Contract\BookRepositoryInterface;
use App\Application\Query\GetBookByUuidQuery;
use App\ViewModel\Book;
use App\ViewModel\Category;

final class GetBookByUuidQueryHandler implements BusHandlerInterface
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
     * @param GetBookByUuidQuery $query
     * @return Book
     */
    public function __invoke(GetBookByUuidQuery $query): Book
    {
        $book = $this->bookRepository->findOneBy(['uuid' => $query->uuid]);

        $category = $book->getCategory();

        return new Book(
            $book->getUuid(),
            $book->getName(),
            $book->getAuthor(),
            $book->getPrice(),
            new Category($category->getUuid(), $category->getName()));
    }
}
