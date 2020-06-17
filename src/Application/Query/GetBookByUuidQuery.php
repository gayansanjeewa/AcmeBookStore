<?php

namespace App\Application\Query;

final class GetBookByUuidQuery
{
    /**
     * @var string
     */
    public $uuid;

    public function __construct(string $uuid)
    {
        $this->uuid = $uuid;
    }
}
