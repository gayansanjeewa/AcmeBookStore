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
    public function findByCategoryCriteria(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null
    ): array;

    /**
     * @param array[]
     *
     * @return Book|null
     */
    public function findOneBy(array $criteria);
}
