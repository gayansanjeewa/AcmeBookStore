<?php

namespace App\ViewModel;

final class Category
{
    /**
     * @var string
     */
    public $uuid;

    /**
     * @var string
     */
    public $name;

    public function __construct(string $uuid, string $name)
    {
        $this->uuid = $uuid;
        $this->name = $name;
    }
}
