<?php

namespace App\Application\Query;

use App\Application\BusHandlerInterface;
use App\Entity\Category;
use Doctrine\Persistence\ManagerRegistry;

final class GetAllCategoriesQueryHandler implements BusHandlerInterface
{
    /**
     * @var ManagerRegistry
     */
    private $managerRegistry;

    /**
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    /**
     * @param GetAllCategoriesQuery $query
     * @return array
     */
    public function __invoke(GetAllCategoriesQuery $query): array
    {
        $repository = $this->managerRegistry->getRepository(Category::class);
        $categories = $repository->findAll();

        $viewCategories = [];
        /** @var Category $category */
        foreach ($categories as $category) {
            $viewCategory = new \App\ViewModel\Category($category->getId(), $category->getName());

            $viewCategories[] = $viewCategory;
        }

        return $viewCategories;
    }
}
