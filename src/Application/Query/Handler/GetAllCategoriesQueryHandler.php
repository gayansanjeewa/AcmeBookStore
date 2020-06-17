<?php

namespace App\Application\Query\Handler;

use App\Application\BusHandlerInterface;
use App\Application\Contract\CategoryRepositoryInterface;
use App\Application\Query\GetAllCategoriesQuery;
use App\Entity\Category;
use App\ViewModel\Category as CategoryViewModel;

final class GetAllCategoriesQueryHandler implements BusHandlerInterface
{
    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @return array|CategoryViewModel[]
     */
    public function __invoke(GetAllCategoriesQuery $query): array
    {
        /** @var Category[] $categories */
        $categories = $this->categoryRepository->findAll();

        $viewCategories = [];
        foreach ($categories as $category) {
            $viewCategories[] = new CategoryViewModel($category->getUuid(), $category->getName());
        }

        return $viewCategories;
    }
}
