<?php

namespace App\Application\Contract;

use App\Entity\Book;

interface BookRepositoryInterface
{
    /**
     * @return array|Book[]
     */
    public function findAll();
}
