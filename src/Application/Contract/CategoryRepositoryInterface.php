<?php

namespace App\Application\Contract;

use App\ViewModel\Category;

interface CategoryRepositoryInterface
{
    /**
     * @return array|Category[]
     */
    public function findAll();
}
