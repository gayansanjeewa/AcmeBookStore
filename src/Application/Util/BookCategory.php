<?php

namespace App\Application\Util;

use Webmozart\Assert\Assert;

final class BookCategory
{
    const CHILDREN = 'children';
    const FICTION = 'fiction';

    /**
     * @var string
     */
    private $category;

    /**
     * BookCategory constructor.
     */
    private function __construct(string $category)
    {
        $this->category = $category;
    }

    /**
     * @return BookCategory
     */
    public static function children(): self
    {
        return self::fromString(static::CHILDREN);
    }

    /**
     * @return BookCategory
     */
    public static function fiction(): self
    {
        return self::fromString(static::FICTION);
    }

    /**
     * @return BookCategory
     */
    public static function fromString(string $category): self
    {
        Assert::oneOf($category, [static::CHILDREN, static::FICTION]);

        return new self($category);
    }

    public function equals(BookCategory $bookCategory): bool
    {
        return $this->asString() === $bookCategory->asString();
    }

    public function asString(): string
    {
        return $this->category;
    }

    public function __toString(): string
    {
        return $this->asString();
    }
}
