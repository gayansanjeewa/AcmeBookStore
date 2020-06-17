<?php

namespace App\Controller\Api;

use App\Application\Query\GetBookByUuidQuery;
use App\Application\Util\Cart;
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
        $cart = $this->applyDiscount($request);

        return new JsonResponse([
            'quantity' => count($cart['items']),
            'total'    => $cart['total'],
        ], Response::HTTP_OK);
    }

    private function applyDiscount(Request $request): array
    {
        /** @var Book $book */
        $book = $this->bus->handle(new GetBookByUuidQuery($request->get('uuid')));

        $cart = $this->getCartFromSession($request->getSession());

        $cart->addItem([
            'bookUuid'  => $book->uuid,
            'category'  => $book->category->name,
            'bookPrice' => $book->price,
        ]);

        $request->getSession()->set('cart', $cart->asArray());

        return $cart->asArray();
    }

    private function getCartFromSession(SessionInterface $session): Cart
    {
        if ($session->has('cart')) {
            return Cart::create($session->get('cart'));
        }

        return Cart::init();
    }
}
