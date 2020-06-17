<?php

namespace App\Tests\Application\Query;

use App\Application\Contract\BookRepositoryInterface;
use App\Application\Query\GetAllBooksQuery;
use App\Application\Query\Handler\GetAllBooksQueryHandler;
use App\Entity\Book;
use App\Entity\Category;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class GetAllBooksQueryHandlerTest extends TestCase
{
    /**
     * @var BookRepositoryInterface|MockObject
     */
    public $bookRepository;

    protected function setUp()
    {
        parent::setUp();

        $this->bookRepository = $this->createMock(BookRepositoryInterface::class);
    }

    /**
     * @test
     */
    public function __invoke_withQueryWithoutCriteria_returnAllBooks()
    {
        $query = new GetAllBooksQuery([]);

        $books = [
            (new Book())
                ->setUuid('9652a4ec-7f39-43ec-b08c-b6491dd15bea')
                ->setName('Foo Bar')
                ->setAuthor('Someone')
                ->setPrice(1000)
                ->setCategory(
                    (new Category())
                        ->setUuid('46909734-ea81-4fe8-b007-c413881764b5')
                        ->setName('fiction')
                ),
        ];

        $this->bookRepository
            ->expects($this->once())
            ->method('findAll')
            ->willReturn($books);

        $this->bookRepository
            ->expects($this->never())
            ->method('findByCategoryCriteria');

        $handler = new GetAllBooksQueryHandler($this->bookRepository);

        $result = $handler->__invoke($query);

        $this->assertInstanceOf(\App\ViewModel\Book::class, $result[0]);
        $this->assertSame('9652a4ec-7f39-43ec-b08c-b6491dd15bea', $result[0]->uuid);
        $this->assertSame('Foo Bar', $result[0]->name);
        $this->assertSame('Someone', $result[0]->author);
        $this->assertSame(1000, $result[0]->price);
        $this->assertSame('46909734-ea81-4fe8-b007-c413881764b5', $result[0]->category->uuid);
        $this->assertSame('fiction', $result[0]->category->name);
    }

    /**
     * @test
     */
    public function __invoke_withQueryWithCriteria_returnMatchingBooks()
    {
        $query = new GetAllBooksQuery([
            'category' => ['46909734-ea81-4fe8-b007-c413881764b5'],
        ]);

        $books = [
            (new Book())
                ->setUuid('9652a4ec-7f39-43ec-b08c-b6491dd15bea')
                ->setName('Foo Bar')
                ->setAuthor('Someone')
                ->setPrice(1000)
                ->setCategory(
                    (new Category())
                        ->setUuid('46909734-ea81-4fe8-b007-c413881764b5')
                        ->setName('fiction')
                ),
        ];

        $this->bookRepository
            ->expects($this->never())
            ->method('findAll');

        $this->bookRepository
            ->expects($this->once())
            ->method('findByCategoryCriteria')
            ->with($this->callback(function ($criteria) {
                return $criteria['category'] === ['46909734-ea81-4fe8-b007-c413881764b5'];
            }))
            ->willReturn($books);

        $handler = new GetAllBooksQueryHandler($this->bookRepository);

        $result = $handler->__invoke($query);

        $this->assertInstanceOf(\App\ViewModel\Book::class, $result[0]);
        $this->assertSame('9652a4ec-7f39-43ec-b08c-b6491dd15bea', $result[0]->uuid);
        $this->assertSame('Foo Bar', $result[0]->name);
        $this->assertSame('Someone', $result[0]->author);
        $this->assertSame(1000, $result[0]->price);
        $this->assertSame('46909734-ea81-4fe8-b007-c413881764b5', $result[0]->category->uuid);
        $this->assertSame('fiction', $result[0]->category->name);
    }
}
