<?php

namespace App\Application\Contract;

use App\Entity\Book;

interface BookRepositoryInterface
{
    /**
     * @return array|Book[]
     */
    public function findAll();

    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @param int|null $limit
     * @param int|null $offset
     *
     * @return array|Book[]
     */
    public function findByCriteria(array $criteria, array $orderBy = null, $limit = null, $offset = null): array;
}
