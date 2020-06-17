<?php

namespace App\Application\Util;

final class Cart
{
    /**
     * @var array
     */
    private $cart;

    /**
     * @var int
     */
    private $childrenCategoryDiscountSatisfiableItemCount = 5;

    /**
     * @var int
     */
    private $totalDiscountSatisfiableItemCount = 10;

    /**
     * @var float
     */
    private $itemCountBasedDiscount = .05;

    /**
     * @var float
     */
    private $couponDiscount = .15;

    /**
     * @var float
     */
    private $childrenCategoryDiscount = .1;

    private function __construct(array $cart)
    {
        $this->cart = $cart;
    }

    public static function create(array $cart): Cart
    {
        return new static($cart);
    }

    /**
     * @return Cart
     */
    public static function init()
    {
        return new static(['items' => [], 'total' => 0]);
    }

    public function addItem(array $array)
    {
        array_push($this->cart['items'], $array);

        $this->recalculateTotal();
    }

    private function recalculateTotal()
    {
        $this->calculateNetTotal();
        $this->applyDiscounts();
    }

    private function calculateNetTotal()
    {
        $total = 0;
        foreach ($this->cart['items'] as $item) {
            $total += $item['bookPrice'];
        }
        $this->cart['total'] = $total;
    }

    private function applyDiscounts()
    {
        $this->applyChildrenCategoryBasedDiscount();
        $this->applyTotalCategoryBasedDiscount();
        $this->applyCouponCodeBasedDiscount();
    }

    private function applyChildrenCategoryBasedDiscount()
    {
        if (empty($this->cart['couponDiscount'])
            && $this->canApplyChildrenCategoryBasedDiscount()) {
            $this->cart['childrenCategoryDiscount'] = $this->cart['total'] * $this->childrenCategoryDiscount;
            $this->cart['total'] -= $this->cart['childrenCategoryDiscount'];
        }
    }

    private function canApplyChildrenCategoryBasedDiscount(): bool
    {
        $childrenBooks = array_filter($this->cart['items'], function ($item) {
            return BookCategory::children()->equals(BookCategory::fromString($item['category']));
        });

        return count($childrenBooks) >= $this->childrenCategoryDiscountSatisfiableItemCount;
    }

    private function applyTotalCategoryBasedDiscount(): void
    {
        if (empty($this->cart['couponDiscount'])
            && $this->canApplyTotalCategoryBasedDiscount()) {
            $this->cart['itemCountBasedDiscount'] = $this->cart['total'] * $this->itemCountBasedDiscount;
            $this->cart['total'] -= $this->cart['itemCountBasedDiscount'];
        }
    }

    private function canApplyTotalCategoryBasedDiscount(): bool
    {
        $childrenBooks = array_filter($this->cart['items'], function ($item) {
            return BookCategory::children()->equals(BookCategory::fromString($item['category']));
        });

        $fictionBooks = array_filter($this->cart['items'], function ($item) {
            return BookCategory::fiction()->equals(BookCategory::fromString($item['category']));
        });

        return count($childrenBooks) >= $this->totalDiscountSatisfiableItemCount || count($fictionBooks) >= $this->totalDiscountSatisfiableItemCount;
    }

    private function applyCouponCodeBasedDiscount(): void
    {
        if (empty($this->cart['coupon'])) {
            return;
        }

        $this->revertChildrenCategoryDiscount();
        $this->revertItemCountBasedDiscount();

        $this->cart['couponDiscount'] = $this->cart['total'] * $this->couponDiscount;
        $this->cart['total'] -= $this->cart['couponDiscount'];
    }

    private function revertChildrenCategoryDiscount(): void
    {
        if (!empty($this->cart['childrenCategoryDiscount'])) {
            $this->cart['total'] += $this->cart['childrenCategoryDiscount'];
        }
    }

    private function revertItemCountBasedDiscount(): void
    {
        if (!empty($this->cart['itemCountBasedDiscount'])) {
            $this->cart['total'] += $this->cart['itemCountBasedDiscount'];
        }
    }

    public function asArray(): array
    {
        return $this->cart;
    }

    public function applyCoupon(string $coupon)
    {
        $this->cart['coupon'] = $coupon;

        $this->recalculateTotal();
    }
}
