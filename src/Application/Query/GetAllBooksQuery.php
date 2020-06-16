<?php

namespace App\Application\Query;

final class GetAllBooksQuery
{
    /**
     * @var array
     */
    public $criteria;

    /**
     * @param array $criteria
     */
    public function __construct(array $criteria)
    {
        $this->criteria = $criteria;
    }
}
