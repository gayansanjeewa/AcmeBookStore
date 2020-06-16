<?php

namespace App\ViewModel;

final class Book
{

    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $author;

    /**
     * @var double
     */
    public $price;

    /**
     * @var Category
     */
    public $category;

    /**
     * @param int $id
     * @param string $name
     * @param string $author
     * @param float $price
     * @param Category $category
     */
    public function __construct(int $id, string $name, string $author, float $price, Category $category)
    {
        $this->id = $id;
        $this->name = $name;
        $this->author = $author;
        $this->price = $price;
        $this->category = $category;
    }
}