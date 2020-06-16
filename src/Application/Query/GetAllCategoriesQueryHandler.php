<?php

namespace App\Application\Query;

use App\Application\BusHandlerInterface;
use App\Application\Contract\CategoryRepositoryInterface;
use App\Entity\Category;

final class GetAllCategoriesQueryHandler implements BusHandlerInterface
{
    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepository;

    /**
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function __invoke(GetAllCategoriesQuery $query): array
    {
        /** @var Category[] $categories */
        $categories = $this->categoryRepository->findAll();

        $viewCategories = [];
        foreach ($categories as $category) {
            $viewCategories[] = new \App\ViewModel\Category($category->getId(), $category->getName());
        }

        return $viewCategories;
    }
}
