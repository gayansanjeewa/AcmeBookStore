<?php

namespace App\Tests\Application\Util;

use App\Application\Util\Cart;
use PHPUnit\Framework\TestCase;

final class CartTest extends TestCase
{
    /**
     * @test
     */
    public function init_void_initiateCartCorrectly()
    {
        $cart = Cart::init();

        $this->assertSame([
            'items' => [],
            'total' => 0,
        ], $cart->asArray());
    }

    /**
     * @test
     */
    public function create_withExistingCart_initiateCartCorrectly()
    {
        $cart = Cart::create([
            'items' => [
                [
                    'bookUuid'  => '7a9a6dc6-fd8e-4d04-bc4e-fb01f978cd07',
                    'category'  => 'fiction',
                    'bookPrice' => '10',
                ],
            ],
            'total' => 10,
        ]);

        $this->assertSame([
            'items' => [
                [
                    'bookUuid'  => '7a9a6dc6-fd8e-4d04-bc4e-fb01f978cd07',
                    'category'  => 'fiction',
                    'bookPrice' => '10',
                ],
            ],
            'total' => 10,
        ], $cart->asArray());
    }

    /**
     * @test
     *
     * @dataProvider dataProvider_addItems_withItem_cartCorrectlyConfigured
     */
    public function addItems_withItem_cartCorrectlyConfigured(Cart $cart, array $item, array $expectation)
    {
        $cart->addItem($item);

        $this->assertSame($expectation, $cart->asArray());
    }

    public function dataProvider_addItems_withItem_cartCorrectlyConfigured(): array
    {
        return [
            'test_if_correctly_configured_for_empty_cart' => [
                Cart::init(),
                [
                    'bookUuid'  => '7a9a6dc6-fd8e-4d04-bc4e-fb01f978cd07',
                    'category'  => 'fiction',
                    'bookPrice' => '10',
                ],
                [
                    'items' => [
                        [
                            'bookUuid'  => '7a9a6dc6-fd8e-4d04-bc4e-fb01f978cd07',
                            'category'  => 'fiction',
                            'bookPrice' => '10',
                        ],
                    ],
                    'total' => 10,
                ],
            ],
            'test_if_correctly_configured_for_cart_already_have_items' => [
                Cart::create([
                    'items' => [
                        [
                            'bookUuid'  => 'fee58cb5-e1a9-4e9a-a3a9-1129c1b460ec',
                            'category'  => 'children',
                            'bookPrice' => '20',
                        ],
                    ],
                    'total' => 20,
                ]),
                [
                    'bookUuid'  => '7a9a6dc6-fd8e-4d04-bc4e-fb01f978cd07',
                    'category'  => 'fiction',
                    'bookPrice' => '10',
                ],
                [
                    'items' => [
                        [
                            'bookUuid'  => 'fee58cb5-e1a9-4e9a-a3a9-1129c1b460ec',
                            'category'  => 'children',
                            'bookPrice' => '20',
                        ],
                        [
                            'bookUuid'  => '7a9a6dc6-fd8e-4d04-bc4e-fb01f978cd07',
                            'category'  => 'fiction',
                            'bookPrice' => '10',
                        ],
                    ],
                    'total' => 30,
                ],
            ],
        ];
    }
}
