<?php

namespace App\ViewModel;

final class Book
{
    /**
     * @var string
     */
    public $uuid;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $author;

    /**
     * @var int
     */
    public $price;

    /**
     * @var Category
     */
    public $category;

    public function __construct(string $uuid, string $name, string $author, int $price, Category $category)
    {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->author = $author;
        $this->price = $price;
        $this->category = $category;
    }
}
