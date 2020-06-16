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
     * @var float
     */
    public $price;

    /**
     * @var Category
     */
    public $category;


    /**
     * @param string $uuid
     * @param string $name
     * @param string $author
     * @param float $price
     * @param Category $category
     */
    public function __construct(string $uuid, string $name, string $author, float $price, Category $category)
    {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->author = $author;
        $this->price = $price;
        $this->category = $category;
    }
}
