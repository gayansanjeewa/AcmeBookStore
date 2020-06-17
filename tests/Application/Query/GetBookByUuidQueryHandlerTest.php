<?php

namespace App\Tests\Application\Query;

use App\Application\Contract\BookRepositoryInterface;
use App\Application\Query\GetBookByUuidQuery;
use App\Application\Query\Handler\GetBookByUuidQueryHandler;
use App\Entity\Book;
use App\Entity\Category;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class GetBookByUuidQueryHandlerTest extends TestCase
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
    public function __invoke_withQueryWithUuid_returnAllBooks()
    {
        $query = new GetBookByUuidQuery('9652a4ec-7f39-43ec-b08c-b6491dd15bea');

        $book = (new Book())
            ->setUuid('9652a4ec-7f39-43ec-b08c-b6491dd15bea')
            ->setName('Foo Bar')
            ->setAuthor('Someone')
            ->setPrice(1000)
            ->setCategory(
                (new Category())
                    ->setUuid('46909734-ea81-4fe8-b007-c413881764b5')
                    ->setName('fiction')
            );

        $this->bookRepository
            ->expects($this->once())
            ->method('findOneBy')
            ->with($this->callback(function ($param) {
                return $param === ['uuid' => '9652a4ec-7f39-43ec-b08c-b6491dd15bea'];
            }))
            ->willReturn($book);

        $handler = new GetBookByUuidQueryHandler($this->bookRepository);

        $result = $handler->__invoke($query);

        $this->assertInstanceOf(\App\ViewModel\Book::class, $result);
        $this->assertSame('9652a4ec-7f39-43ec-b08c-b6491dd15bea', $result->uuid);
        $this->assertSame('Foo Bar', $result->name);
        $this->assertSame('Someone', $result->author);
        $this->assertSame(1000, $result->price);
        $this->assertSame('46909734-ea81-4fe8-b007-c413881764b5', $result->category->uuid);
        $this->assertSame('fiction', $result->category->name);
    }
}
