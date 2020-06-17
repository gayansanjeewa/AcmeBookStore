<?php

namespace App\Tests\Application\Query;

use App\Application\Contract\CategoryRepositoryInterface;
use App\Application\Query\GetAllCategoriesQuery;
use App\Application\Query\Handler\GetAllCategoriesQueryHandler;
use App\Entity\Category;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class GetAllCategoriesQueryHandlerTest extends TestCase
{
    /**
     * @var CategoryRepositoryInterface|MockObject
     */
    public $categoryRepository;

    protected function setUp()
    {
        parent::setUp();

        $this->categoryRepository = $this->createMock(CategoryRepositoryInterface::class);
    }

    /**
     * @test
     */
    public function __invoke_withQueryWithQuery_returnAllBooks()
    {
        $categories = [
            (new Category())
                ->setUuid('46909734-ea81-4fe8-b007-c413881764b5')
                ->setName('fiction'),
            (new Category())
                ->setUuid('9652a4ec-7f39-43ec-b08c-b6491dd15bea')
                ->setName('children'),
        ];

        $this->categoryRepository
            ->expects($this->once())
            ->method('findAll')
            ->willReturn($categories);

        $handler = new GetAllCategoriesQueryHandler($this->categoryRepository);

        $result = $handler->__invoke(new GetAllCategoriesQuery());

        $this->assertInstanceOf(\App\ViewModel\Category::class, $result[0]);
        $this->assertSame('46909734-ea81-4fe8-b007-c413881764b5', $result[0]->uuid);
        $this->assertSame('fiction', $result[0]->name);

        $this->assertInstanceOf(\App\ViewModel\Category::class, $result[1]);
        $this->assertSame('9652a4ec-7f39-43ec-b08c-b6491dd15bea', $result[1]->uuid);
        $this->assertSame('children', $result[1]->name);
    }
}
