<?php

namespace App\Controller\Api;

use App\Application\Query\GetBookByUuidQuery;
use App\Application\Util\BookCategory;
use App\ViewModel\Book;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

final class AddBookToCartController extends AbstractController
{
    /**
     * @var CommandBus
     */
    private $bus;

    public function __construct(CommandBus $bus)
    {
        $this->bus = $bus;
    }

    /**
     * @Route("/api/cart/book", name="api_cart_add_book", methods={"POST"})
     */
    public function __invoke(Request $request): JsonResponse
    {
        $cart = $this->getShoppingCart($request);

//        $request->getSession()->remove('cart'); // TODO: remove this code placed for debugging

        return new JsonResponse([
            'quantity' => count($cart['items']),
            'total'    => $cart['total'],
        ], Response::HTTP_OK);
    }

    protected function getShoppingCart(Request $request): array
    {
        /** @var Book $book */
        $book = $this->bus->handle(new GetBookByUuidQuery($request->get('uuid')));

        $cart = $this->getCartFromSession($request->getSession());

        $item = [
            'bookUuid'  => $book->uuid,
            'category'  => $book->category->name,
            'bookPrice' => $book->price,
        ];

        array_push($cart['items'], $item);

        $cart['total'] = $this->calculateTotal($cart);

        $applyChildrenCategoryDiscount = $this->applyChildrenCategoryDiscount($cart);
        $applyTotalCategoryDiscount = $this->applyTotalCategoryDiscount($cart);

        if ($applyChildrenCategoryDiscount) {
            $cart['total'] = $cart['total'] * (1 - .1);
        }

        if ($applyTotalCategoryDiscount) {
            $cart['total'] = $cart['total'] * (1 - .05);
        }

        $request->getSession()->set('cart', $cart);

        return $cart;
    }

    protected function getCartFromSession(SessionInterface $session): array
    {
        if ($session->has('cart')) {
            return $session->get('cart');
        }

        $session->set('cart', ['items' => [], 'total' => 0]);

        return $session->get('cart');
    }

    protected function calculateTotal(array $cart): float
    {
        $total = 0;
        foreach ($cart['items'] as $item) {
            $total += $item['bookPrice'];
        }

        return $total / 100;
    }

    protected function applyChildrenCategoryDiscount(array $cart): bool
    {
        $discountSatisfiableChildrenCategoryCount = 5;

        $childrenBooks = array_filter($cart['items'], function ($item) {
            return BookCategory::children()->equals(BookCategory::fromString($item['category']));
        });

        return count($childrenBooks) >= $discountSatisfiableChildrenCategoryCount;
    }

    private function applyTotalCategoryDiscount(array $cart)
    {
        $discountSatisfiableCount = 10;

        $childrenBooks = array_filter($cart['items'], function ($item) {
            return BookCategory::children()->equals(BookCategory::fromString($item['category']));
        });

        $fictionBooks = array_filter($cart['items'], function ($item) {
            return BookCategory::children()->equals(BookCategory::fromString($item['category']));
        });

        return count($childrenBooks) >= $discountSatisfiableCount && count($fictionBooks) >= $discountSatisfiableCount;
    }
}
